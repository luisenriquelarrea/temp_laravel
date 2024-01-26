<?php

namespace Database\Seeders;

use App\Models\TipoOtroPago;
use Illuminate\Database\Seeder;

class TipoOtroPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoOtroPago::factory()->create();
    }
}
