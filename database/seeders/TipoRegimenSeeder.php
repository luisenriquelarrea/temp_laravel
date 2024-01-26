<?php

namespace Database\Seeders;

use App\Models\TipoRegimen;
use Illuminate\Database\Seeder;

class TipoRegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoRegimen::factory()->create();
    }
}
