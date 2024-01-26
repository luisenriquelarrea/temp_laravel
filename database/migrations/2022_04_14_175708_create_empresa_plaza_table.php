<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaPlazaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_plaza', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('codigo_postal_id')->nullable();
            $table->string('colonia')->nullable();
            $table->string('calle')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('numero_interior')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['empresa_id', 'plaza_id']);
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresa')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('plaza_id')
                ->references('id')
                ->on('plaza')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('pais_id')
                ->references('id')
                ->on('pais')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('estado_id')
                ->references('id')
                ->on('estado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipio')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('codigo_postal_id')
                ->references('id')
                ->on('codigo_postal')
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
        Schema::dropIfExists('empresa_plaza');
    }
}
