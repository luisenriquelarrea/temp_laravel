<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('regimen_fiscal_id')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('codigo_postal_id')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('pagina_web')->nullable();
            $table->string('colonia')->nullable();
            $table->string('calle')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('numero_interior')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['razon_social', 'rfc']);
            $table->foreign('regimen_fiscal_id')
                ->references('id')
                ->on('regimen_fiscal')
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
        Schema::dropIfExists('cliente');
    }
}
