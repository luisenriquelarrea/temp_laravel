<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_empresa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('empresa_sueldos_id')->nullable();
            $table->unsignedBigInteger('empresa_contable_id')->nullable();
            $table->unsignedBigInteger('empresa_asimilados_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['plaza_id', 'empleado_id', 'empresa_sueldos_id', 'empresa_contable_id'], 
                'unique_empleado_empresa');
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
            $table->foreign('empresa_sueldos_id')
                ->references('id')
                ->on('empresa')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empresa_contable_id')
                ->references('id')
                ->on('empresa')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empresa_asimilados_id')
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
        Schema::dropIfExists('empleado_empresa');
    }
}
