<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSueldosSalariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sueldos_salarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ejercicio_id')->nullable();
            $table->integer('n_dias_pagados')->nullable();
            $table->integer('n_dias_vacaciones')->nullable();
            $table->double('sd', 10, 4)->default(0.0000);
            $table->double('sdi', 10, 4)->default(0.0000);
            $table->double('sueldos_salarios', 10, 4)->default(0.0000);
            $table->double('bono_septimo_dia', 10, 4)->default(0.0000);
            $table->double('bono_puntualidad', 10, 4)->default(0.0000);
            $table->double('bono_asistencia', 10, 4)->default(0.0000);
            $table->double('subsidio_empleo_causado', 10, 4)->default(0.0000);
            $table->double('subsidio_empleo_entregado', 10, 4)->default(0.0000);
            $table->double('isr_determinado', 10, 4)->default(0.0000);
            $table->double('isr_pagar', 10, 4)->default(0.0000);
            $table->double('imss', 10, 4)->default(0.0000);
            $table->double('neto', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('ejercicio_id')
                ->references('id')
                ->on('ejercicio')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sueldos_salarios');
    }
}
