<?php

namespace Database\Seeders;

use App\Models\RegimenFiscal;
use Illuminate\Database\Seeder;

class RegimenFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RegimenFiscal::factory()->create();
    }
}
