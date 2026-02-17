<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\DescargaMasivaSatService;

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
    protected $signature = 'app:sat-create-download';

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
        $this->info('Server timezone: ' . config('app.timezone'));
        $this->info('PHP timezone: ' . date_default_timezone_get());
        $this->info('Current PHP time: ' . now()->toDateTimeString());
        $this->info('UTC time: ' . now()->utc()->toDateTimeString());

        $this->info('Iniciando solicitud SAT...');

        $requestId = $this->service->createRequest(
            '2026-02-16 00:00:00',
            '2026-02-16 23:59:59'
        );

        $this->info("Solicitud creada: {$requestId}");
    }
}
