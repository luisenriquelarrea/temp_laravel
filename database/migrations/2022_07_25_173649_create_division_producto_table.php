<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_producto_id')->nullable();
            $table->string('codigo')->nullable()->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('tipo_producto_id')
                ->references('id')
                ->on('tipo_producto')
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
        Schema::dropIfExists('division_producto');
    }
}
