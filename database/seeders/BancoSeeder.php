<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banco;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banco::factory()->create();
    }
}
