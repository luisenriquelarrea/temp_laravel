<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReciboTipoOtroPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo_tipo_otro_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->unsignedBigInteger('tipo_otro_pago_id')->nullable();
            $table->double('monto', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('recibo_id')
                ->references('id')
                ->on('recibo')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('tipo_otro_pago_id')
                ->references('id')
                ->on('tipo_otro_pago')
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
        Schema::dropIfExists('recibo_otro_pago');
    }
}
