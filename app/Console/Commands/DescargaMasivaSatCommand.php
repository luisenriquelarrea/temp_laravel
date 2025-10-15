<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use GuzzleHttp\Client as GuzzleClient;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;
use Throwable;

class DescargaMasivaSatCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sat:download 
        {--start=2025-09-01 00:00:00 : Fecha de inicio del periodo}
        {--end=2025-09-01 23:59:59 : Fecha de fin del periodo}
        {--type=received : Tipo de descarga (issued|received)}
        {--request=xml : Tipo de solicitud (metadata|xml)}';

    /**
     * The console command description.
     */
    protected $description = 'Descarga masiva CFDI desde el SAT usando FIEL.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info(PHP_EOL . '=== Iniciando Descarga Masiva SAT ===');
        $this->newLine();

        $cert = storage_path('app/ssl/certificado.cer');
        $key = storage_path('app/ssl/claveprivada.key');
        $passw = config('wssat.passw');

        if (! file_exists($cert) || ! file_exists($key)) {
            $this->error('❌ Archivos de certificado o llave privada no encontrados en storage/app/ssl/');
            return $this::FAILURE;
        }

        // 1️⃣ Crear FIEL
        try {
            $this->info('🔐 Creando FIEL...');
            $fiel = Fiel::create(
                file_get_contents($cert),
                file_get_contents($key),
                $passw
            );

            if (! $fiel->isValid()) {
                $this->error('❌ FIEL inválida o expirada. Verifique que sea FIEL (no CSD) y esté vigente.');
                return $this::FAILURE;
            }

            $this->info('✅ FIEL válida y vigente.');
        } catch (Throwable $e) {
            $this->error("❌ Error al crear FIEL: {$e->getMessage()}");
            \Log::error('Error creando FIEL', ['exception' => $e]);
            return $this::FAILURE;
        }

        // 2️⃣ Crear cliente SAT
        $this->info('🌐 Preparando conexión SAT...');
        $guzzleClient = new GuzzleClient([
            'debug' => false,
            'timeout' => 30,
            'connect_timeout' => 10,
        ]);
        
        $webClient = new GuzzleWebClient($guzzleClient);
        $requestBuilder = new FielRequestBuilder($fiel);
        $service = new Service($requestBuilder, $webClient);

        $this->line('📡 Endpoints SAT activos:');

        $endpoints = $service->getEndpoints();
        $this->line('   Query: ' . $endpoints->getQuery());
        $this->line('   Verify: ' . $endpoints->getVerify());
        $this->line('   Download: ' . $endpoints->getDownload());

        // 3️⃣ Construir parámetros
        $start = $this->option('start');
        $end = $this->option('end');
        $type = $this->option('type');
        $requestType = $this->option('request');

        $this->info("📅 Periodo: $start → $end");
        $this->info("📤 Tipo descarga: $type | Tipo solicitud: $requestType");

        $request = QueryParameters::create()
            ->withPeriod(DateTimePeriod::createFromValues($start, $end))
            ->withDownloadType($type === 'issued' ? DownloadType::issued() : DownloadType::received())
            ->withRequestType($requestType === 'xml' ? RequestType::xml() : RequestType::metadata())
            ->withDocumentType(DocumentType::ingreso())
            ->withComplement(ComplementoCfdi::leyendasFiscales10())
            ->withDocumentStatus(DocumentStatus::active());

        $maxRetries = 3;
        $retry = 0;
        $query = null;
            
        $this->info('🚀 Enviando consulta al SAT...');
        
        do {
            try {
                $query = $service->query($request);
        
                if ($query->getStatus()->isAccepted()) {
                    $this->info('✅ Consulta aceptada por el SAT.');
                    break;
                }
        
                $retry++;
                $msg = $query->getStatus()->getMessage() ?: 'Respuesta vacía del SAT';
                $this->warn("⚠️ Intento {$retry}/{$maxRetries}: {$msg}");
                \Log::warning('SAT query retry', [
                    'attempt' => $retry,
                    'message' => $msg,
                    'status_code' => $query->getStatus()->getCode(),
                ]);
        
                // Small delay before retrying
                sleep(10);
        
            } catch (Throwable $e) {
                $retry++;
                $this->error("❌ Excepción en intento {$retry}/{$maxRetries}: {$e->getMessage()}");
                \Log::error('SAT query exception', [
                    'attempt' => $retry,
                    'exception' => $e,
                ]);
                sleep(5);
            }
        
        } while ($retry < $maxRetries);
        
        if (! $query || ! $query->getStatus()->isAccepted()) {
            $this->error("❌ Error persistente tras {$maxRetries} intentos. El SAT devolvió 500 o no respondió correctamente.");
            return $this::FAILURE;
        }
        
        $requestId = $query->getRequestId();
        $this->info("✅ Solicitud aceptada. ID: {$requestId}");
        

        // 5️⃣ Verificar estado
        try {
            $this->info('🔍 Verificando estado de solicitud...');
            $verify = $service->verify($requestId);

            if (! $verify->getStatus()->isAccepted()) {
                $this->error("❌ Error verificando solicitud: {$verify->getStatus()->getMessage()}");
                return $this::FAILURE;
            }

            $status = $verify->getStatusRequest();
            if ($status->isInProgress()) {
                $this->warn("⏳ La solicitud {$requestId} sigue en proceso. Intente más tarde.");
                return $this::SUCCESS;
            }

            if ($status->isFinished()) {
                $this->info("✅ La solicitud {$requestId} está lista para descarga.");
            }

            $packages = $verify->getPackagesIds();
            $this->info("📦 Paquetes encontrados: " . count($packages));

            if (empty($packages)) {
                $this->warn('⚠️ No se encontraron paquetes disponibles.');
                return $this::SUCCESS;
            }
        } catch (Throwable $e) {
            $this->error("❌ Error al verificar solicitud: {$e->getMessage()}");
            \Log::error('Error verificando solicitud SAT', ['exception' => $e]);
            return $this::FAILURE;
        }

        // 6️⃣ Descargar paquetes
        try {
            foreach ($packages as $packageId) {
                $this->info("⬇️ Descargando paquete {$packageId}...");
                $download = $service->download($packageId);

                if (! $download->getStatus()->isAccepted()) {
                    $this->warn("⚠️ El paquete {$packageId} no se pudo descargar: {$download->getStatus()->getMessage()}");
                    continue;
                }

                $savePath = storage_path("app/sat/{$packageId}.zip");
                if (! file_exists(dirname($savePath))) {
                    mkdir(dirname($savePath), 0755, true);
                }

                file_put_contents($savePath, $download->getPackageContent());
                $this->info("✅ Paquete guardado en: {$savePath}");
            }
        } catch (Throwable $e) {
            $this->error("❌ Error descargando paquetes: {$e->getMessage()}");
            \Log::error('Error descargando paquetes SAT', ['exception' => $e]);
            return $this::FAILURE;
        }

        $this->newLine();
        $this->info('🎉 Descarga Masiva SAT completada con éxito.');
        \Log::info('SAT download completed successfully.');
        return $this::SUCCESS;
    }
}