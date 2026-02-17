<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\DescargaMasivaSatService;

class SatVerifyDownload extends Command
{
    protected DescargaMasivaSatService $service;

    public function __construct(DescargaMasivaSatService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sat-verify-download {requestId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $requestId = $this->argument('requestId');

        $this->info("Verificando solicitud: {$requestId}");

        $verify = $this->service->verifyRequest($requestId);

        // Verificación SOAP correcta
        if (! $verify->getStatus()->isAccepted()) {
            $this->error(
                "Fallo al verificar la consulta {$requestId}: " .
                $verify->getStatus()->getMessage()
            );
            return 1;
        }

        // SAT rechazó la solicitud
        if (! $verify->getCodeRequest()->isAccepted()) {
            $this->error(
                "La solicitud {$requestId} fue rechazada: " .
                $verify->getCodeRequest()->getMessage()
            );
            return 1;
        }

        // Estado del proceso
        $statusRequest = $verify->getStatusRequest();

        if ($statusRequest->isExpired()) {
            $this->error("La solicitud {$requestId} expiró.");
            return;
        }

        if ($statusRequest->isFailure()) {
            $this->error("La solicitud {$requestId} falló.");
            return;
        }

        if ($statusRequest->isRejected()) {
            $this->error("La solicitud {$requestId} fue rechazada por SAT.");
            return;
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            $this->warn("La solicitud {$requestId} se está procesando...");
            return;
        }

        if ($statusRequest->isFinished()) {
            $this->info("La solicitud {$requestId} está lista.");
        }

        $this->info("Se encontraron {$verify->countPackages()} paquetes");

        $results = $this->service->downloadRequest($verify->getPackagesIds());

        foreach ($results as $packageId => $result) {

            if (! $result['success']) {
                $this->error("Error en {$packageId}: {$result['message']}");
                continue;
            }

            $this->info("Paquete {$packageId} descargado correctamente");
        }

        return 0;
    }
}
