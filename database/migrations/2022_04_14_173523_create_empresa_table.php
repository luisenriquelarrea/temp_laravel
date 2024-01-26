<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('regimen_fiscal_id')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->boolean('es_persona_fisica')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('regimen_fiscal_id')
                ->references('id')
                ->on('regimen_fiscal')
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
        Schema::dropIfExists('empresa');
    }
}
