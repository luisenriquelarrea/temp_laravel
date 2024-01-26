<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsidioEmpleoQuincenalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsidio_empleo_quincenal', function (Blueprint $table) {
            $table->id();
            $table->double('limite_inferior', 10, 4)->default(0.0000);
            $table->double('limite_superior', 10, 4)->default(0.0000);
            $table->double('cuota_fija', 10, 4)->default(0.0000);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subsidio_empleo_quincenal');
    }
}
