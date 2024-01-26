<?php

namespace Database\Seeders;

use App\Models\RiesgoPuesto;
use Illuminate\Database\Seeder;

class RiesgoPuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RiesgoPuesto::factory()->create();
    }
}
