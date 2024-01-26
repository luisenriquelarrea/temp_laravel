<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplementoPagoDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complemento_pago_documento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complemento_pago_id')->nullable();
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->double('monto', 10, 4)->default(0.0000);
            $table->double('saldo_anterior', 10, 4)->default(0.0000);
            $table->double('saldo_insoluto', 10, 4)->default(0.0000);
            $table->integer('n_parcialidad')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['complemento_pago_id', 'factura_id']);
            $table->foreign('complemento_pago_id')
                ->references('id')
                ->on('complemento_pago')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('factura_id')
                ->references('id')
                ->on('factura')
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
        Schema::dropIfExists('complemento_pago_documento');
    }
}
