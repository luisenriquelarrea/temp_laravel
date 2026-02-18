<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

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
        $this->info('Iniciando solicitud SAT...');

        $yesterday = Carbon::now('America/Mexico_City')->subDay();

        $requestId = $this->service->createRequest(
            $yesterday->copy()->startOfDay()->format('Y-m-d H:i:s'),
            $yesterday->copy()->endOfDay()->format('Y-m-d H:i:s')
        );

        $this->info("Solicitud creada: {$requestId}");
    }
}
