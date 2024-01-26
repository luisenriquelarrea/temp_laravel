<?php

namespace Database\Seeders;

use App\Models\TipoCambio;
use Illuminate\Database\Seeder;

class TipoCambioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCambio::factory()->create();
    }
}
