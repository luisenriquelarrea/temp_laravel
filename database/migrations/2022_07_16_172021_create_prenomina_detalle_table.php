<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrenominaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenomina_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prenomina_id')->nullable();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->double('n_dias_sueldos', 10, 3)->default(0.000);
            $table->double('n_dias_contable', 10, 3)->default(0.000);
            $table->double('total_sueldo_base', 10, 4)->default(0.0000);
            $table->double('total_bonos_contable', 10, 4)->default(0.0000);
            $table->double('total_sueldos_salarios', 10, 4)->default(0.0000);
            $table->double('total_bonos_sueldos', 10, 4)->default(0.0000);
            $table->double('total_subsidio_empleo', 10, 4)->default(0.0000);
            $table->double('total_isr', 10, 4)->default(0.0000);
            $table->double('total_imss', 10, 4)->default(0.0000);
            $table->double('total_infonavit', 10, 4)->default(0.0000);
            $table->double('total_descuentos', 10, 4)->default(0.0000);
            $table->double('total_incidencias', 10, 4)->default(0.0000);
            $table->double('neto_sueldos_salarios', 10, 4)->default(0.0000);
            $table->double('neto_asimilados', 10, 4)->default(0.0000);
            $table->double('neto_contable', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('prenomina_id')
                ->references('id')
                ->on('prenomina')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
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
        Schema::dropIfExists('prenomina_detalle');
    }
}
