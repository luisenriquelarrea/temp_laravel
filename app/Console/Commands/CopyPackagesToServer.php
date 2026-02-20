<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Models\SatDownloadPackage;

class CopyPackagesToServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:copy-packages-to-server {date?}';

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

        if ($inputDate) {
            try {
                $date = Carbon::createFromFormat('Y-m-d', $inputDate);
            } catch (\Exception $e) {
                $this->error('Invalid date format. Use Y-m-d (example: 2026-02-15)');
                return 1;
            }
        } else 
            $date = now()->subDay();

        $start = $date->copy()->startOfDay();
        $end   = $date->copy()->endOfDay();

        $this->info("Copying ZIP from: " . $date->toDateString());

        $packages = SatDownloadPackage::whereHas('request', function ($query) use ($start, $end) {
            $query->where('status', 'completed')
                ->where('is_cron_request', true)
                ->whereBetween('date_from', [$start, $end]);
        })
        ->where('is_copied', false)
        ->get();

        if ($packages->isEmpty()) {
            $this->info('No packages found to copy for ' . $date->toDateString());
            return 0;
        }

        foreach ($packages as $package) {
            $path = "sat/{$package->package_id}.zip";

            if (!Storage::exists($path)){
                $this->error("File not found: {$path}");
                continue;
            }

            $base64 = base64_encode(
                Storage::get($path)
            );

            $payload = [
                'zip' => 'data:application/x-zip-compressed;base64,' . $base64
            ];

            $base_url = config('services.springboot.base_url');
            $api_key = config('services.springboot.api_key');
            $api_token = config('services.springboot.api_token');

            $response = Http::baseUrl($base_url)
                ->withHeaders([
                    $api_key => $api_token,
                    'Accept'    => 'application/json',
                ])
                ->timeout(60)
                ->retry(3, 2000)
                ->post('/cfdi/add', $payload);

            if ($response->successful()) {
                $package->update([
                    'is_copied' => true,
                ]);
                $this->info("Copied package {$package->package_id}");
            } else
                $this->error("Failed copying package {$package->package_id}");
        }
        
        return 0;
    }
}
