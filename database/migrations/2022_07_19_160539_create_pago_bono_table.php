<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoBonoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_bono', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bono_id')->nullable();
            $table->unsignedBigInteger('periodo_pago_id')->nullable();
            $table->unsignedBigInteger('recibo_percepcion_id')->nullable();
            $table->double('monto', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('bono_id')
                ->references('id')
                ->on('bono')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('periodo_pago_id')
                ->references('id')
                ->on('periodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('recibo_percepcion_id')
                ->references('id')
                ->on('recibo_percepcion')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pago_bono');
    }
}
