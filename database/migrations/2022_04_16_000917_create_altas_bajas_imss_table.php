<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAltasBajasImssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('altas_bajas_imss', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->double('salario_diario', 10, 4)->default(0.0000);
            $table->double('salario_diario_integrado', 10, 4)->default(0.0000);
            $table->date('fecha')->nullable();
            $table->string('movimiento')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['plaza_id', 'empleado_id', 'empresa_id', 'movimiento'], 
                'unique_altas_bajas_imss');
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('plaza_id')
                ->references('id')
                ->on('plaza')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresa')
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
        Schema::dropIfExists('altas_bajas_imss');
    }
}
