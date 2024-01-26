<?php

namespace Database\Seeders;

use App\Models\Deduccion;
use Illuminate\Database\Seeder;

class DeduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deduccion::factory()->create();
    }
}
