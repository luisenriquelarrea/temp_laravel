<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->unsignedBigInteger('puesto_id')->nullable();
            $table->unsignedBigInteger('puesto_fiscal_id')->nullable();
            $table->unsignedBigInteger('regimen_fiscal_id')->nullable();
            $table->unsignedBigInteger('periodicidad_pago_id')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('codigo_postal_id')->nullable();
            $table->unsignedBigInteger('pais_fiscal_id')->nullable();
            $table->unsignedBigInteger('estado_fiscal_id')->nullable();
            $table->unsignedBigInteger('municipio_fiscal_id')->nullable();
            $table->unsignedBigInteger('codigo_postal_fiscal_id')->nullable();
            $table->unsignedBigInteger('pais_nacionalidad_id')->nullable();
            $table->unsignedBigInteger('estado_nacionalidad_id')->nullable();
            $table->unsignedBigInteger('municipio_nacionalidad_id')->nullable();
            $table->unsignedBigInteger('empleado_jefe_inmediato_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('nss')->nullable();
            $table->string('sexo')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('colonia')->nullable();
            $table->string('domicilio')->nullable();
            $table->double('salario_base', 10, 4)->default(0.0000);
            $table->double('salario_diario', 10, 4)->default(0.0000);
            $table->double('salario_diario_integrado', 10, 4)->default(0.0000);
            $table->double('salario_asimilados', 10, 4)->default(0.0000);
            $table->date('fecha_inicio_laboral')->nullable();
            $table->date('fecha_baja_laboral')->nullable();
            $table->date('fecha_alta_imss')->nullable();
            $table->date('fecha_baja_imss')->nullable();
            $table->string('numero_infonavit')->nullable();
            $table->double('pago_infonavit', 10, 4)->default(0.0000);
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
            $table->foreign('puesto_id')
                ->references('id')
                ->on('puesto')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('regimen_fiscal_id')
                ->references('id')
                ->on('regimen_fiscal')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('periodicidad_pago_id')
                ->references('id')
                ->on('periodicidad_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('pais_id')
                ->references('id')
                ->on('pais')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('estado_id')
                ->references('id')
                ->on('estado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipio')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('codigo_postal_id')
                ->references('id')
                ->on('codigo_postal')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empleado_jefe_inmediato_id')
                ->references('id')
                ->on('empleado')
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
        Schema::dropIfExists('empleado');
    }
}
