<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaCreditoDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_documento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_credito_id')->nullable();
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->boolean('status')->default(true);
            $table->unique(['nota_credito_id', 'factura_id']);
            $table->timestamps();
            $table->foreign('nota_credito_id')
                ->references('id')
                ->on('nota_credito')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('factura_id')
                ->references('id')
                ->on('factura')
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
        Schema::dropIfExists('nota_credito_documento');
    }
}
