<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaCuentaBancariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_cuenta_bancaria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('banco_id')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('numero_tarjeta')->nullable();
            $table->string('clabe_interbancaria')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['empresa_id', 'banco_id', 'clabe_interbancaria'], 'UQ_emp_cb');
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresa')
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
        Schema::dropIfExists('empresa_cuenta_bancaria');
    }
}
