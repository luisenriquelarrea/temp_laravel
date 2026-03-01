<?php

namespace App\Console\Commands;

use App\Models\SatDownloadRequest;
use App\Services\DescargaMasivaSatService;
use App\Services\TelegramService;

use Carbon\Carbon;

use Illuminate\Console\Command;

class ExpireStuckRequests extends Command
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
    protected $signature = 'app:expire-stuck-requests';

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
        $date = Carbon::now('America/Mexico_City');
        
        $start = $date->copy()->startOfDay();
        $end   = $date->copy()->endOfDay();

        $expiredRequests = SatDownloadRequest::whereIn('status', ['accepted', 'in_progress', 'partial', 'failed'])
            ->where('created_at', '<', now()->subHours(2))
            ->where('is_cron_request', true)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $request_recreate = [];

        foreach ($expiredRequests as $request) {
            $error_message = "Request {$request->request_id} expired due to timeout.";

            $request->update([
                'status' => 'expired',
                'error_message' => $error_message
            ]);

            $end = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $request->date_to,
                'America/Mexico_City'
            );

            $randomEndSecond = random_int(0, 58);
            $end->setSecond($randomEndSecond);

            $request_recreate[] = [
                'start' => $request->date_from,
                'end' => $end,
                'document_type' => $request->document_type,
                'document_status' => $request->document_status
            ];

            $message = "[{$request->document_type}, {$request->document_status}] {$error_message}";

            app(TelegramService::class)
                ->notify_from_server($message);

            $this->info($message);
        }

        foreach ($request_recreate as $request){
            $this->create_request($request);
        }
    }

    private function create_request($request){
        $document_type = $request['document_type'];
        $document_status = $request['document_status'];

        if (SatDownloadRequest::whereDate('created_at', today())
            ->where('document_type', $document_type)
            ->where('document_status', $document_status)
            ->whereIn('status', ['created','accepted','in_progress'])
            ->exists()) {
            return;
        }

        $this->info("Creating request type of: {$document_type}");

        $requestId = $this->service->createRequest([
            'start' => $request['start'],
            'end' => $request['end'],
            'document_type' => $document_type,
            'document_status' => $document_status,
            'is_cron_request' => true
        ]);

        $message = "[{$document_type}, {$document_status}] Request created: {$requestId}";

        app(TelegramService::class)
            ->notify_from_server($message);

        $this->info($message);
    }
}
