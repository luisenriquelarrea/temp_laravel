<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateComplementoPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complemento_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('metodo_pago_id')->nullable();
            $table->unsignedBigInteger('forma_pago_id')->nullable();
            $table->unsignedBigInteger('tipo_cambio_id')->nullable();
            $table->unsignedBigInteger('tipo_comprobante_id')->nullable();
            $table->unsignedBigInteger('uso_cfdi_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('serie')->nullable();
            $table->string('folio')->nullable();
            $table->date('fecha')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('hora')->nullable();
            $table->double('monto', 10, 4)->default(0.0000);
            $table->string('uuid')->nullable();
            $table->text('observaciones');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['empresa_id', 'serie', 'folio']);
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
            $table->foreign('metodo_pago_id')
                ->references('id')
                ->on('metodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('forma_pago_id')
                ->references('id')
                ->on('forma_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_cambio_id')
                ->references('id')
                ->on('tipo_cambio')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_comprobante_id')
                ->references('id')
                ->on('tipo_comprobante')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('uso_cfdi_id')
                ->references('id')
                ->on('uso_cfdi')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('cliente_id')
                ->references('id')
                ->on('cliente')
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
        Schema::dropIfExists('complemento_pago');
    }
}
