<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodicidadPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodicidad_pago', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('n_elementos')->nullable();
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
        Schema::dropIfExists('periodicidad_pago');
    }
}
