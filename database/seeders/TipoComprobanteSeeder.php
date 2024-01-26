<?php

namespace Database\Seeders;

use App\Models\TipoComprobante;
use Illuminate\Database\Seeder;

class TipoComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoComprobante::factory()->create();
    }
}
