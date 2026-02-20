<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Models\SatDownloadRequest;

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

        $date = $inputDate
            ? Carbon::parse($inputDate)
            : now()->subDay();

        $start = $date->copy()->startOfDay();
        $end   = $date->copy()->endOfDay();

        $this->info("Copying ZIP from: " . $date->toDateString());

        $requests = SatDownloadRequest::where('status', 'completed')
            ->where('is_cron_request', true)
            ->whereBetween('date_from', [$start, $end])
            ->get();

        foreach ($requests as $request) {
            foreach ($request->packages as $package) {
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
                    $this->info("Sent package {$package->id}");
                } else {
                    $this->error("Failed sending package {$package->id}");
                }
            }
        }
        
        return 0;
    }
}
