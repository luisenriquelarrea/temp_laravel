<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculoNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculo_nomina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recibo_id')->nullable()->unique();
            $table->unsignedBigInteger('periodo_pago_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('plaza_id')->nullable();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->double('total_gravado', 10, 4)->default(0.0000);
            $table->double('total_gravado_mensual', 10, 4)->default(0.0000);
            $table->double('sueldos_salarios', 10, 4)->default(0.0000);
            $table->double('subsidio_empleo_causado_periodo', 10, 4)->default(0.0000);
            $table->double('subsidio_empleo_causado_mensual', 10, 4)->default(0.0000);
            $table->double('subsidio_empleo_entregado_periodo', 10, 4)->default(0.0000);
            $table->double('subsidio_empleo_entregado_mensual', 10, 4)->default(0.0000);
            $table->double('isr_determinado_periodo', 10, 4)->default(0.0000);
            $table->double('isr_determinado_mensual', 10, 4)->default(0.0000);
            $table->double('isr_pagar_periodo', 10, 4)->default(0.0000);
            $table->double('isr_pagar_mensual', 10, 4)->default(0.0000);
            $table->double('imss', 10, 4)->default(0.0000);
            $table->double('infonavit', 10, 4)->default(0.0000);
            $table->double('neto', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('recibo_id')
                ->references('id')
                ->on('recibo')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('periodo_pago_id')
                ->references('id')
                ->on('periodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
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
            $table->foreign('empleado_id')
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
        Schema::dropIfExists('calculo_nomina');
    }
}
