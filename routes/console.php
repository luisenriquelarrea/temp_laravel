<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Fabrica;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('truncate', function () {
    $this->comment('Truncating all tables');
    try{
        Schema::disableForeignKeyConstraints();
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;    
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }
        Schema::enableForeignKeyConstraints();
        $this->comment('Truncate finished.');
        $this->comment('Don\'t forget to run db:seed');
    }catch(Exception $e){
        $this->comment('Error !');
        $this->comment($e->getMessage());
        Schema::enableForeignKeyConstraints();
    }
})->purpose('Truncate all tables in database');

Artisan::command('seedAllFactories', function(){
    $this->comment('Making seeders all factories');
    $fabrica = Fabrica::select('fabrica.descripcion')
        ->where('fabrica.status', '=', 1)
        ->orderBy('fabrica.id', 'ASC')
        ->get()
        ->toArray();
    if(count($fabrica) === 0){
        $fabrica = [
            'Banco',
            'CodigoPostal',
            'Deduccion',
            'Departamento',
            'Ejercicio',
            'EmpleadoCuentaBancaria',
            'EmpleadoEmpresa',
            'Empleado',
            'EmpresaCuentaBancaria',
            'Empresa',
            'Estado',
            'Exportacion',
            'FormaPago',
            'Mes',
            'MetodoPago',
            'Moneda',
            'MotivoCancelacion',
            'Municipio',
            'Pais',
            'Percepcion',
            'PeriodicidadPago',
            'PeriodoPago',
            'Plaza',
            'Puesto',
            'RegimenFiscal',
            'RiesgoPuesto',
            'SalarioMinimo',
            'TipoCambio',
            'TipoComprobante',
            'TipoContrato',
            'TipoDeduccion',
            'TipoIncapacidad',
            'TipoNomina',
            'TipoOtroPago',
            'TipoPercepcion',
            'TipoRecibo',
            'TipoRegimen',
            'TipoRelacion',
            'Uma',
            'Unidad',
            'UsoCfdi'
        ];
    }
    foreach($fabrica as $key => $valor){
        $seeder = $valor['descripcion'].'Seeder';
        Artisan::call('make:seeder '.$seeder);
        Artisan::output();
    }
})->purpose('Make seeders all factories classes');