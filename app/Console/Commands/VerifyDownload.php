<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Services\DescargaMasivaSatService;
use App\Services\TelegramService;

use App\Models\SatDownloadPackage;
use App\Models\SatDownloadRequest;

class VerifyDownload extends Command
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
    protected $signature = 'app:verify-download {date?}';

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
        $inputDate = $this->argument('date');

        try {
            $date = $inputDate
                ? Carbon::createFromFormat('Y-m-d', $inputDate, 'America/Mexico_City')
                : Carbon::now('America/Mexico_City');
        } catch (\Exception $e) {
            $this->error('Invalid date format. Use Y-m-d (example: 2026-02-15)');
            return 1;
        }

        $start = $date->copy()->startOfDay();
        $end   = $date->copy()->endOfDay();

        $request = null;

        /**
         * STEP 1: Safely fetch one pending request
         */
        DB::transaction(function () use ($start, $end, &$request) {
            $request = SatDownloadRequest::whereIn('status', [
                'created',
                'accepted',
                'in_progress',
                'finished'
            ])
            ->where(function ($query) {
                $query->whereNull('last_verified_at')
                      ->orWhere('last_verified_at', '<', now()->subMinutes(5));
            })
            ->whereBetween('created_at', [$start, $end])
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

            $message = "Verify failed {$requestId}: " .
                $verify->getStatus()->getMessage();

            $request->update([
                'status' => 'failed',
                'error_message' => $message
            ]);

            app(TelegramService::class)
                ->notify_from_server($message);

            $this->error($message);
            return 1;
        }

        if (! $verify->getCodeRequest()->isAccepted()) {

            $message = "Request {$requestId} rejected: " .
                $verify->getCodeRequest()->getMessage();

            $request->update([
                'status' => 'rejected',
                'error_message' => $message
            ]);

            app(TelegramService::class)
                ->notify_from_server($message);

            $this->error($message);
            return 1;
        }

        $statusRequest = $verify->getStatusRequest();

        /**
         * STEP 3: Handle SAT state machine
         */
        if ($statusRequest->isExpired()) {

            $message = "Request {$requestId} expired.";

            $request->update([
                'status' => 'failed',
                'error_message' => $message
            ]);

            app(TelegramService::class)
                ->notify_from_server($message);

            $this->error($message);
            return 0;
        }

        if ($statusRequest->isFailure()) {

            $message = "Request {$requestId} failed.";

            $request->update([
                'status' => 'failed',
                'error_message' => $message
            ]);

            app(TelegramService::class)
                ->notify_from_server($message);

            $this->error($message);
            return 0;
        }

        if ($statusRequest->isRejected()) {

            $message = "Request {$requestId} was rejected by SAT.";

            $request->update([
                'status' => 'rejected',
                'error_message' => $message
            ]);

            app(TelegramService::class)
                ->notify_from_server($message);

            $this->error($message);
            return 0;
        }

        if ($statusRequest->isInProgress()) {

            $request->update(['status' => 'in_progress']);

            $message = "Request {$requestId} is in progress...";

            $this->warn($message);
            return 0;
        }

        if ($statusRequest->isAccepted()) {

            $request->update(['status' => 'accepted']);

            $message = "Request {$requestId} was accepted and its in progress...";

            $this->warn($message);
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

        if (in_array($request->status, ['completed', 'partial'])) {
            return 0;
        }

        /**
         * STEP 5: Download packages safely
         */
        $results = $this->service->downloadRequest($verify->getPackagesIds());

        $downladedPackages = "";

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

            $message = "Package {$packageId} downloaded.";
            $downladedPackages .= "{$message}\n";

            $this->info($message);
        }

        app(TelegramService::class)
            ->notify_from_server($downladedPackages);

        /**
         * STEP 6: Final state resolution
         */
        $packages = SatDownloadPackage::where('sat_download_request_id', $request->id)->get();

        $totalPackages = $packages->count();
        $failedCount = $packages->where('status', 'failed')->count();
        $downloadedCount = $packages->where('status', 'downloaded')->count();

        if ($failedCount === $totalPackages && $totalPackages > 0) {
            // All packages failed
            $request->update(['status' => 'failed']);

        } elseif ($downloadedCount === $totalPackages && $totalPackages > 0) {
            // All packages succeeded
            $request->update(['status' => 'completed']);

        } elseif ($failedCount > 0 && $downloadedCount > 0) {
            // Mixed result
            $request->update(['status' => 'partial']);

        } else {
            // Still processing or unknown state
            $request->update(['status' => 'in_progress']);
        }

        return 0;
    }
}
