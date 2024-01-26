<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaCanceladaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_cancelada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id')->nullable()->unique();
            $table->unsignedBigInteger('motivo_cancelacion_id')->nullable();
            $table->date('fecha')->nullable();
            $table->text('acuse_cancelacion');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('factura_id')
                ->references('id')
                ->on('factura')
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
        Schema::dropIfExists('factura_cancelada');
    }
}
