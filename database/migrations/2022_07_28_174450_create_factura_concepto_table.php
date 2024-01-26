<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaConceptoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_concepto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->unsignedBigInteger('concepto_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->double('cantidad', 10, 3)->default(0.000);
            $table->double('precio_unitario', 10, 4)->default(0.0000);
            $table->double('importe', 10, 4)->default(0.0000);
            $table->double('descuento', 10, 4)->default(0.0000);
            $table->double('iva_trasladado', 10, 4)->default(0.0000);
            $table->double('iva_retenido', 10, 4)->default(0.0000);
            $table->double('isr_retenido', 10, 4)->default(0.0000);
            $table->double('ieps_trasladado', 10, 4)->default(0.0000);
            $table->double('subtotal', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('factura_id')
                ->references('id')
                ->on('factura')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('concepto_id')
                ->references('id')
                ->on('concepto')
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
        Schema::dropIfExists('factura_concepto');
    }
}
