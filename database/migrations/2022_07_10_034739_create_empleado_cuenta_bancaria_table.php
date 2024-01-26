<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoCuentaBancariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_cuenta_bancaria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('tipo_recibo_id')->nullable();
            $table->unsignedBigInteger('banco_id')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('numero_tarjeta')->nullable();
            $table->string('clabe_interbancaria')->nullable();
            $table->boolean('es_cheque')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_recibo_id')
                ->references('id')
                ->on('tipo_recibo')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('banco_id')
                ->references('id')
                ->on('banco')
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
        Schema::dropIfExists('empleado_cuenta_bancaria');
    }
}
