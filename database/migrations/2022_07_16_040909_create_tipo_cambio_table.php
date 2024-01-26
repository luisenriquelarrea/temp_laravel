<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoCambioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_cambio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('moneda_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->date('fecha')->nullable();
            $table->double('monto', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('moneda_id')
                ->references('id')
                ->on('moneda')
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
        Schema::dropIfExists('tipo_cambio');
    }
}
