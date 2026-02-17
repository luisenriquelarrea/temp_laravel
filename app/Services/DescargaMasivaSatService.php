<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

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

        //$webClient = new GuzzleWebClient();
        $requestBuilder = new FielRequestBuilder($fiel);

        return new Service($requestBuilder, $webClient);
    }

    public function createRequest(string $start, string $end): string
    {
        $service = $this->createService();

        $request = QueryParameters::create()
            ->withPeriod(DateTimePeriod::createFromValues($start, $end))
            //->withDownloadType(DownloadType::received())
            ->withRequestType(RequestType::xml());
            //->withDocumentType(DocumentType::ingreso())
            //->withDocumentStatus(DocumentStatus::active());

        //$query = $service->query($request);

        try {
            $query = $service->query($request);
        } catch (\Throwable $e) {
            dd($e->getPrevious());
        }

        if (!$query->getStatus()->isAccepted()) {
            throw new RuntimeException(
                'Error al crear solicitud: ' . $query->getStatus()->getMessage()
            );
        }

        return $query->getRequestId();
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
