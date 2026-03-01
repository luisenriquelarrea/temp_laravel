<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Services\DescargaMasivaSatService;
use App\Services\TelegramService;

class RecibidosCancelados extends Command
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
    protected $signature = 'app:recibidos-cancelados
                        {date?}
                        {--ingresos : Download ingresos only}
                        {--egresos : Download egresos only}
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

            //$start = $date->copy()->startOfYear()->startOfDay();
            $start = $date->copy()->subDays(3)->startOfDay();
            $end   = $date->copy()->endOfDay();
        }

        if ($this->option('limitReached')) {
            $randomEndSecond = random_int(0, 58);
            $end->setSecond($randomEndSecond);
        }

        $start = $start->format('Y-m-d H:i:s');
        $end = $end->format('Y-m-d H:i:s');

        $ingresos = $this->option('ingresos');
        $egresos  = $this->option('egresos');

        $document_type = null;

        if ($ingresos && ! $egresos)
            $document_type = 'ingreso';
        elseif ($egresos && ! $ingresos)
            $document_type = 'egreso';

        $this->info('Starting SAT request from: ' . $date->toDateString());

        $this->create_request($start, $end, $document_type);

        return 0;
    }

    private function create_request(string $start, string $end, ?string $document_type){
        $this->info("Creating cancelled request type of: ". ($document_type ?? 'mixed'));

        $options = [
            'start' => $start,
            'end' => $end,
            'document_status' => 'cancelled',
            'is_cron_request' => true
        ];

        if(! is_null($document_type))
            $options['document_type'] = $document_type;

        $requestId = $this->service->createRequest($options);

        $message = "Request created: {$requestId}";

        app(TelegramService::class)
            ->notify_from_server($message);

        $this->info($message);
    }
}
