<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bono', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('percepcion_id')->nullable();
            $table->unsignedBigInteger('periodo_pago_id')->nullable();
            $table->unsignedBigInteger('tipo_recibo_id')->nullable();
            $table->double('monto', 10, 4)->default(0.0000);
            $table->double('saldo', 10, 4)->default(0.0000);
            $table->text('comentarios');
            $table->boolean('tiempo_indeterminado')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('percepcion_id')
                ->references('id')
                ->on('percepcion')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('periodo_pago_id')
                ->references('id')
                ->on('periodo_pago')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_recibo_id')
                ->references('id')
                ->on('tipo_recibo')
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
        Schema::dropIfExists('bono');
    }
}
