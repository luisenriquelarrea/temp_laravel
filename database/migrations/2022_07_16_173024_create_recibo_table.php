<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReciboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomina_id')->nullable();
            $table->unsignedBigInteger('prenomina_detalle_id')->nullable();
            $table->unsignedBigInteger('tipo_recibo_id')->nullable();
            $table->unsignedBigInteger('periodo_pago_id')->nullable();
            $table->unsignedBigInteger('tipo_cambio_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->string('folio')->nullable();
            $table->date('fecha')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->double('n_dias_pagados', 10, 3)->default(0.000);
            $table->double('sd', 10, 4)->default(0.000);
            $table->double('sdi', 10, 4)->default(0.000);
            $table->string('uuid')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('nomina_id')
                ->references('id')
                ->on('nomina')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('prenomina_detalle_id')
                ->references('id')
                ->on('prenomina_detalle')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_recibo_id')
                ->references('id')
                ->on('tipo_recibo')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('periodo_pago_id')
                ->references('id')
                ->on('periodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_cambio_id')
                ->references('id')
                ->on('tipo_cambio')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresa')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('plaza_id')
                ->references('id')
                ->on('plaza')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('departamento_id')
                ->references('id')
                ->on('departamento')
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
        Schema::dropIfExists('recibo');
    }
}
