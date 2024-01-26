<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplementoPagoCanceladoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complemento_pago_cancelado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complemento_pago_id')->nullable()->unique();
            $table->unsignedBigInteger('motivo_cancelacion_id')->nullable();
            $table->date('fecha')->nullable();
            $table->text('acuse_cancelacion');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('complemento_pago_id')
                ->references('id')
                ->on('complemento_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('motivo_cancelacion_id')
                ->references('id')
                ->on('motivo_cancelacion')
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
        Schema::dropIfExists('complemento_pago_cancelado');
    }
}
