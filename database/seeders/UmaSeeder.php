<?php

namespace Database\Seeders;

use App\Models\Uma;
use Illuminate\Database\Seeder;

class UmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Uma::factory()->create();
    }
}
