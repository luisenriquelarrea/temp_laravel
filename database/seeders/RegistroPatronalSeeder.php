<?php

namespace Database\Seeders;

use App\Models\RegistroPatronal;
use Illuminate\Database\Seeder;

class RegistroPatronalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RegistroPatronal::factory()->create();
    }
}
