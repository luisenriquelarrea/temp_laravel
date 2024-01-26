<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaCreditoCanceladaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_cancelada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_credito_id')->nullable()->unique();
            $table->unsignedBigInteger('motivo_cancelacion_id')->nullable();
            $table->date('fecha')->nullable();
            $table->text('acuse_cancelacion');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('nota_credito_id')
                ->references('id')
                ->on('nota_credito')
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
        Schema::dropIfExists('nota_credito_cancelada');
    }
}
