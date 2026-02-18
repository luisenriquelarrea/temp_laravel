<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Services\DescargaMasivaSatService;

use App\Models\SatDownloadPackage;
use App\Models\SatDownloadRequest;

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
    protected $signature = 'app:sat-verify-download';

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
        $request = null;

        /**
         * STEP 1: Safely fetch one pending request
         */
        DB::transaction(function () use (&$request) {
            $request = SatDownloadRequest::whereIn('status', [
                'created',
                'accepted',
                'in_progress',
                'finished' // allow resume if needed
            ])
            ->where(function ($query) {
                $query->whereNull('last_verified_at')
                      ->orWhere('last_verified_at', '<', now()->subMinutes(5));
            })
            ->lockForUpdate()
            ->orderBy('created_at')
            ->first();

            if ($request) {
                $request->update([
                    'last_verified_at' => now()
                ]);
            }
        });

        if (! $request) {
            $this->info('No pending SAT requests.');
            return 0;
        }

        $requestId = $request->request_id;

        $this->info("Verificando solicitud: {$requestId}");

        /**
         * STEP 2: Verify request with SAT
         */
        $verify = $this->service->verifyRequest($requestId);

        // SOAP validation
        if (! $verify->getStatus()->isAccepted()) {

            $message = "Fallo al verificar {$requestId}: " .
                $verify->getStatus()->getMessage();

            $request->update([
                'status' => 'failed',
                'error_message' => $message
            ]);

            $this->error($message);
            return 1;
        }

        if (! $verify->getCodeRequest()->isAccepted()) {

            $message = "Solicitud {$requestId} rechazada: " .
                $verify->getCodeRequest()->getMessage();

            $request->update([
                'status' => 'rejected',
                'error_message' => $message
            ]);

            $this->error($message);
            return 1;
        }

        $statusRequest = $verify->getStatusRequest();

        /**
         * STEP 3: Handle SAT state machine
         */
        if ($statusRequest->isExpired()) {

            $message = "La solicitud {$requestId} expiró.";

            $request->update([
                'status' => 'failed',
                'error_message' => $message
            ]);

            $this->error($message);
            return 0;
        }

        if ($statusRequest->isFailure()) {

            $message = "La solicitud {$requestId} falló.";

            $request->update([
                'status' => 'failed',
                'error_message' => $message
            ]);

            $this->error($message);
            return 0;
        }

        if ($statusRequest->isRejected()) {

            $message = "La solicitud {$requestId} fue rechazada por SAT.";

            $request->update([
                'status' => 'rejected',
                'error_message' => $message
            ]);

            $this->error($message);
            return 0;
        }

        if ($statusRequest->isInProgress()) {

            $request->update(['status' => 'in_progress']);

            $this->warn("La solicitud {$requestId} se está procesando...");
            return 0;
        }

        if ($statusRequest->isAccepted()) {

            $request->update(['status' => 'accepted']);

            $this->warn("La solicitud {$requestId} fue aceptada y está en proceso...");
            return 0;
        }

        /**
         * STEP 4: Finished → Download packages
         */
        if (! $statusRequest->isFinished()) {
            return 0;
        }

        $packagesCount = $verify->countPackages();

        $request->update([
            'status' => 'finished',
            'packages_count' => $packagesCount,
        ]);

        $this->info("Solicitud {$requestId} lista.");
        $this->info("Se encontraron {$packagesCount} paquetes.");

        // If already completed, skip
        if (in_array($request->status, ['completed', 'partial'])) {
            return 0;
        }

        /**
         * STEP 5: Download packages safely
         */
        $results = $this->service->downloadRequest($verify->getPackagesIds());

        foreach ($results as $packageId => $result) {

            $data = [
                'sat_download_request_id' => $request->id,
                'package_id' => $packageId,
            ];

            if (! $result['success']) {

                $message = "Error en {$packageId}: {$result['message']}";

                $data['status'] = 'failed';
                $data['error_message'] = $message;

                SatDownloadPackage::updateOrCreate(
                    ['package_id' => $packageId],
                    $data
                );

                $this->error($message);
                continue;
            }

            $data['status'] = 'downloaded';

            SatDownloadPackage::updateOrCreate(
                ['package_id' => $packageId],
                $data
            );

            $this->info("Paquete {$packageId} descargado correctamente");
        }

        /**
         * STEP 6: Final state resolution
         */
        $failedCount = SatDownloadPackage::where('sat_download_request_id', $request->id)
            ->where('status', 'failed')
            ->count();

        $request->update([
            'status' => $failedCount === 0 ? 'completed' : 'partial'
        ]);

        return 0;
    }
}
