<?php

namespace Database\Seeders;

use App\Models\MotivoCancelacion;
use Illuminate\Database\Seeder;

class MotivoCancelacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MotivoCancelacion::factory()->create();
    }
}
