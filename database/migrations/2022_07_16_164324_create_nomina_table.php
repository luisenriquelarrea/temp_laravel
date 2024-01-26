<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->unsignedBigInteger('periodo_pago_id')->nullable();
            $table->unsignedBigInteger('tipo_cambio_id')->nullable();
            $table->string('folio')->nullable();
            $table->string('descripcion')->nullable();
            $table->date('fecha')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->boolean('es_aguinaldo')->default(true);
            $table->boolean('es_finiquito')->default(true);
            $table->boolean('es_ptu')->default(true);
            $table->boolean('nomina_ok')->default(true);
            $table->boolean('pago_ok')->default(true);
            $table->boolean('timbrado_ok')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('plaza_id')
                ->references('id')
                ->on('plaza')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('departamento_id')
                ->references('id')
                ->on('departamento')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('periodo_pago_id')
                ->references('id')
                ->on('periodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_cambio_id')
                ->references('id')
                ->on('tipo_cambio')
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
        Schema::dropIfExists('nomina');
    }
}
