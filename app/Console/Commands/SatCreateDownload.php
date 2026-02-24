<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Services\DescargaMasivaSatService;
use App\Services\TelegramService;

class SatCreateDownload extends Command
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
    protected $signature = 'app:sat-create-download {date?}';

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
        }
        else
            $date = Carbon::now('America/Mexico_City')->subDay();

        $start = $date->copy()->startOfDay()->format('Y-m-d H:i:s');
        $end = $date->copy()->endOfDay()->format('Y-m-d H:i:s');

        $this->info('Iniciando solicitud SAT from: ' . $date->toDateString());

        $requestId = $this->service->createRequest([
            'start' => $start,
            'end' => $end,
            'is_cron_request' => true
        ]);

        $message = "Solicitud creada: {$requestId}";

        app(TelegramService::class)
            ->notify_from_server($message);

        $this->info($message);
    }
}
