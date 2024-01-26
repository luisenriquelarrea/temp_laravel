<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduccion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_deduccion_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('tipo_deduccion_id')
                ->references('id')
                ->on('tipo_deduccion')
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
        Schema::dropIfExists('deduccion');
    }
}
