<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoReciboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_recibo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_regimen_id')->nullable();
            $table->unsignedBigInteger('tipo_nomina_id')->nullable();
            $table->unsignedBigInteger('tipo_contrato_id')->nullable();
            $table->unsignedBigInteger('tipo_jornada_id')->nullable();
            $table->unsignedBigInteger('riesgo_puesto_id')->nullable();
            $table->string('codigo')->nullable()->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('es_cfdi')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('tipo_regimen_id')
                ->references('id')
                ->on('tipo_regimen')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_nomina_id')
                ->references('id')
                ->on('tipo_nomina')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_contrato_id')
                ->references('id')
                ->on('tipo_contrato')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_jornada_id')
                ->references('id')
                ->on('tipo_jornada')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('riesgo_puesto_id')
                ->references('id')
                ->on('riesgo_puesto')
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
        Schema::dropIfExists('tipo_recibo');
    }
}
