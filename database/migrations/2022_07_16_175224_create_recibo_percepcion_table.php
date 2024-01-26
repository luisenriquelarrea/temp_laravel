<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReciboPercepcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo_percepcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->unsignedBigInteger('percepcion_id')->nullable();
            $table->double('monto_gravado', 10, 4)->default(0.0000);
            $table->double('monto_exento', 10, 4)->default(0.0000);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('recibo_id')
                ->references('id')
                ->on('recibo')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('percepcion_id')
                ->references('id')
                ->on('percepcion')
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
        Schema::dropIfExists('recibo_percepcion');
    }
}
