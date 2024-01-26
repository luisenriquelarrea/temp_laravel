<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodoPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodicidad_pago_id')->nullable();
            $table->unsignedBigInteger('ejercicio_id')->nullable();
            $table->unsignedBigInteger('mes_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->boolean('ajuste_subsidio_empleo')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('periodicidad_pago_id')
                ->references('id')
                ->on('periodicidad_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('ejercicio_id')
                ->references('id')
                ->on('ejercicio')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('mes_id')
                ->references('id')
                ->on('mes')
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
        Schema::dropIfExists('periodo_pago');
    }
}
