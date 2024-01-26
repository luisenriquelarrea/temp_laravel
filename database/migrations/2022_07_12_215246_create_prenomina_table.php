<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrenominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenomina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_pago_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('prenomina_ok')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['periodo_pago_id', 'plaza_id', 'departamento_id'], 
                'unique_prenomina');
            $table->foreign('periodo_pago_id')
                ->references('id')
                ->on('periodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prenomina');
    }
}
