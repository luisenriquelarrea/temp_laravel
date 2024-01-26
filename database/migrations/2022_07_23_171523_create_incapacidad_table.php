<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncapacidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->unsignedBigInteger('tipo_incapacidad_id')->nullable();
            $table->string('folio')->nullable();
            $table->double('n_dias_autorizados', 10, 3)->default(0.000);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleado')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('tipo_incapacidad_id')
                ->references('id')
                ->on('tipo_incapacidad')
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
        Schema::dropIfExists('incapacidad');
    }
}
