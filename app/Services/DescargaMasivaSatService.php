<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

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
    private string $cert;
    private string $key;
    private string $password;

    public function __construct()
    {
        $this->cert = storage_path('app/ssl/certificado.cer');
        $this->key = storage_path('app/ssl/claveprivada.key');
        $this->password = config('wssat.passw');
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

    /**
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

    public function createRequest(string $start, string $end): string
    {
        return DB::transaction(function () use ($start, $end) {

            $service = $this->createService();

            $request = QueryParameters::create()
                ->withPeriod(DateTimePeriod::createFromValues($start, $end))
                ->withRequestType(RequestType::xml())
                ->withDocumentType(DocumentType::ingreso())
                ->withDownloadType(DownloadType::received())
                ->withDocumentStatus(DocumentStatus::active());

            $query = $service->query($request);

            if (!$query->getStatus()->isAccepted()) {
                throw new RuntimeException(
                    'Error al crear solicitud: ' . $query->getStatus()->getMessage()
                );
            }

            $requestId = $query->getRequestId();

            SatDownloadRequest::create([
                'request_id' => $requestId,
                'date_from' => $start,
                'date_to' => $end,
                'status' => 'created',
                'is_cron_request' => true
            ]);

            return $requestId;
        });
    }

    public function createCustomRequest(array $params): string
    {
        return DB::transaction(function () use ($params) {

            $service = $this->createService();

            $dateFrom = Carbon::parse($params['date_from'])
                ->startOfDay()
                ->format('Y-m-d H:i:s');

            $dateTo = Carbon::parse($params['date_to'])
                ->endOfDay()
                ->format(format: 'Y-m-d H:i:s');

            $request = QueryParameters::create()
                ->withPeriod(
                    DateTimePeriod::createFromValues($dateFrom, $dateTo)
                )
                ->withDownloadType(DownloadType::{$params['download_type']}())
                ->withRequestType(RequestType::{$params['request_type']}())
                ->withDocumentType(DocumentType::{$params['document_type']}())
                ->withDocumentStatus(DocumentStatus::{$params['document_status']}());

            $query = $service->query($request);

            if (!$query->getStatus()->isAccepted()) {
                throw new RuntimeException(
                    'Error al crear solicitud: ' . $query->getStatus()->getMessage()
                );
            }

            $requestId = $query->getRequestId();

            SatDownloadRequest::create([
                'request_id' => $requestId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'status' => 'created',
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
