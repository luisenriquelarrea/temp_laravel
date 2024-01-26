<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidad_id')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('no_identificacion')->nullable();
            $table->double('factor_iva_retenido', 10, 6)->default(0.000000);
            $table->double('factor_iva_trasladado', 10, 6)->default(0.000000);
            $table->double('factor_isr_retenido', 10, 6)->default(0.000000);
            $table->double('factor_ieps_trasladado', 10, 6)->default(0.000000);
            $table->boolean('exento')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('unidad_id')
                ->references('id')
                ->on('unidad')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('producto_id')
                ->references('id')
                ->on('producto')
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
        Schema::dropIfExists('concepto');
    }
}
