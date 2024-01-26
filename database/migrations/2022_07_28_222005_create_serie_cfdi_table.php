<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerieCfdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serie_cfdi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('serie')->nullable();
            $table->integer('folio_inicial_nomina')->nullable();
            $table->integer('folio_inicial_factura')->nullable();
            $table->integer('folio_inicial_complemento')->nullable();
            $table->integer('folio_inicial_nota_credito')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['plaza_id', 'empresa_id', 'serie']);
            $table->foreign('plaza_id')
                ->references('id')
                ->on('plaza')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresa')
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
        Schema::dropIfExists('serie_cfdi');
    }
}
