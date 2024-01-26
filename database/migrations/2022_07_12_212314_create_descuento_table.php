<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescuentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('deduccion_id')->nullable();
            $table->unsignedBigInteger('tipo_recibo_id')->nullable();
            $table->double('total_descuento', 10, 4)->default(0.0000);
            $table->double('total_pagado', 10, 4)->default(0.0000);
            $table->double('saldo', 10, 4)->default(0.0000);
            $table->double('monto_descuento_fijo', 10, 4)->default(0.0000);
            $table->double('porcentaje_descuento', 10, 4)->default(0.0000);
            $table->integer('n_pagos_descuento')->default(0);
            $table->date('fecha_inicio')->nullable();
            $table->text('comentarios');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('deduccion_id')
                ->references('id')
                ->on('deduccion')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_recibo_id')
                ->references('id')
                ->on('tipo_recibo')
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
        Schema::dropIfExists('descuento');
    }
}
