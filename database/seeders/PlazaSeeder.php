<?php

namespace Database\Seeders;

use App\Models\Plaza;
use Illuminate\Database\Seeder;

class PlazaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plaza::factory()->create();
    }
}
