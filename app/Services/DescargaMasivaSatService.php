<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\SatDownloadRequest;

use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Services\Verify\VerifyResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

use GuzzleHttp\Client;

use RuntimeException;

class DescargaMasivaSatService
{
    /**
     * QueryParameters examples
     * 
     * $query = QueryParameters::create()
     *   ->withPeriod(DateTimePeriod::createFromValues('2019-01-13 00:00:00', '2019-01-13 23:59:59'))
     *   ->withDownloadType(DownloadType::received())
     *   ->withRequestType(RequestType::xml())
     *   ->withDocumentType(DocumentType::ingreso())
     *   ->withComplement(ComplementoCfdi::leyendasFiscales10())
     *   ->withDocumentStatus(DocumentStatus::active())
     *   ->withRfcOnBehalf(RfcOnBehalf::create('XXX01010199A'))
     *   ->withRfcMatch(RfcMatch::create('MAG041126GT8'))
     *   ->withUuid(Uuid::create('96623061-61fe-49de-b298-c7156476aa8b'))
     */

    private string $cert;
    private string $key;
    private string $password;

    public function __construct()
    {
        $this->cert = storage_path('app/ssl/certificado.cer');
        $this->key = storage_path('app/ssl/claveprivada.key');
        $this->password = config('services.sat.passw');
    }

    private function createService(): Service
    {
        $fiel = Fiel::create(
            file_get_contents($this->cert),
            file_get_contents($this->key),
            $this->password
        );

        if (!$fiel->isValid()) {
            throw new RuntimeException('La FIEL no es válida o está vencida');
        }

        $guzzle = new Client([
            'verify' => true,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
            ],
        ]);

        $webClient = new GuzzleWebClient($guzzle);

        $requestBuilder = new FielRequestBuilder($fiel);

        return new Service($requestBuilder, $webClient);
    }

    private function getQueryParameters(array $options)
    {
        $defaults = [
            'start' => null,
            'end' => null,
            'request_type' => 'xml',
            'download_type' => 'received',
            'document_status' => 'active',
        ];

        $options = array_merge(
            $defaults,
            array_filter($options, fn ($value) => !is_null($value))
        );

        // SAT rule: cancelled -> metadata only
        if ($options['document_status'] === 'cancelled') 
            $options['request_type'] = 'metadata';

        return $options;
    }

    public function createRequest(array $options): string
    {
        return DB::transaction(function () use ($options) {

            $service = $this->createService();

            $options = $this->getQueryParameters($options);

            $request = QueryParameters::create()
                ->withPeriod(DateTimePeriod::createFromValues(
                    $options['start'],
                    $options['end']
                ))
                ->withDownloadType(DownloadType::{$options['download_type']}())
                ->withRequestType(RequestType::{$options['request_type']}())
                ->withDocumentStatus(DocumentStatus::{$options['document_status']}());

            $document_type = "mixed";

            if (! empty($options['document_type'])){
                $document_type = $options['document_type'];

                $request->withDocumentType(
                    DocumentType::{$document_type}()
                );
            }

            $query = $service->query($request);

            if (!$query->getStatus()->isAccepted()) {
                $message = 'Error al crear solicitud: ' . $query->getStatus()->getMessage();

                app(TelegramService::class)
                    ->notify_from_server($message);
                
                throw new RuntimeException($message);
            }

            $requestId = $query->getRequestId();

            SatDownloadRequest::create([
                'request_id' => $requestId,
                'date_from' => $options['start'],
                'date_to' => $options['end'],
                'status' => 'created',
                'document_status' => $options['document_status'],
                'document_type' => $document_type,
                'is_cron_request' => $options['is_cron_request']
            ]);

            return $requestId;
        });
    }

    public function verifyRequest(string $requestId): VerifyResult
    {
        $service = $this->createService();

        $result = $service->verify($requestId);

        return $result;
    }

    public function downloadRequest(array $packagesIds): array
    {
        $service = $this->createService();

        $results = [];

        foreach ($packagesIds as $packageId) {

            $download = $service->download($packageId);

            if (! $download->getStatus()->isAccepted()) {
                $results[$packageId] = [
                    'success' => false,
                    'message' => $download->getStatus()->getMessage(),
                ];
                continue;
            }

            Storage::makeDirectory('sat');

            Storage::put(
                "sat/{$packageId}.zip",
                $download->getPackageContent()
            );

            $results[$packageId] = [
                'success' => true,
                'message' => 'Downloaded successfully',
            ];
        }

        return $results;
    }
}
