<?php

namespace Database\Seeders;

use App\Models\UsoCfdi;
use Illuminate\Database\Seeder;

class UsoCfdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UsoCfdi::factory()->create();
    }
}
