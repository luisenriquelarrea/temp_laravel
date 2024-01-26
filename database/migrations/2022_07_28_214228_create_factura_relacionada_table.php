<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaRelacionadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_relacionada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->unsignedBigInteger('cfdi_relacionado_id')->nullable();
            $table->unsignedBigInteger('tipo_relacion_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['factura_id', 'cfdi_relacionado_id']);
            $table->foreign('factura_id')
                ->references('id')
                ->on('factura')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('cfdi_relacionado_id')
                ->references('id')
                ->on('factura')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_relacion_id')
                ->references('id')
                ->on('tipo_relacion')
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
        Schema::dropIfExists('factura_relacionada');
    }
}
