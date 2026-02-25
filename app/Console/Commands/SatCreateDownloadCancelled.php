<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Services\DescargaMasivaSatService;
use App\Services\TelegramService;

class SatCreateDownloadCancelled extends Command
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
    protected $signature = 'app:sat-create-download-cancelled
                        {date?}
                        {--limitReached : Randomize seconds to avoid duplicate lifetime limit}';

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
                $date = Carbon::createFromFormat(
                    'Y-m-d',
                    $inputDate,
                    'America/Mexico_City'
                );

                $start = $date->copy()->startOfDay();
                $end   = $date->copy()->endOfDay();
            } catch (\Exception $e) {
                $this->error('Invalid date format. Use Y-m-d (example: 2026-02-15)');
                return 1;
            }
        } else {
            $date = Carbon::now('America/Mexico_City')->subDay();

            $start = $date->copy()->startOfYear()->startOfDay();
            $end   = $date->copy()->endOfDay();
        }

        if ($this->option('limitReached')) {
            $randomEndSecond = random_int(0, 58);
            $end->setSecond($randomEndSecond);
        }

        $start = $start->format('Y-m-d H:i:s');
        $end = $end->format('Y-m-d H:i:s');

        $this->info('Iniciando solicitud SAT from: ' . $date->toDateString());

        $requestId = $this->service->createRequest([
            'start' => $start,
            'end' => $end,
            'document_status' => 'cancelled',
            'is_cron_request' => true
        ]);

        $message = "Request cancelled created: {$requestId}";

        app(TelegramService::class)
            ->notify_from_server($message);

        $this->info($message);
    }
}
