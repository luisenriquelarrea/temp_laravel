<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->string('codigo')->nullable();
            $table->string('codigo_curp')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('pais_id')
                ->references('id')
                ->on('pais')
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
        Schema::dropIfExists('estado');
    }
}
