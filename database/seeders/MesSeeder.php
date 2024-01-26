<?php

namespace Database\Seeders;

use App\Models\Mes;
use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mes::factory()->create();
    }
}
