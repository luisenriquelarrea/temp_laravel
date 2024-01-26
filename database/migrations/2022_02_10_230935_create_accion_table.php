<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seccion_menu_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('call_method')->nullable();
            $table->string('label')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('on_navbar')->default(false);
            $table->boolean('on_table')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['seccion_menu_id', 'descripcion']);
            $table->foreign('seccion_menu_id')
                ->references('id')
                ->on('seccion_menu')
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
        Schema::dropIfExists('accion');
    }
}
