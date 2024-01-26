<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccion_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->string('descripcion')->nullable()->unique();
            $table->string('navbar_label')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('menu_id')
                ->references('id')
                ->on('menu')
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
        Schema::dropIfExists('seccion_menu');
    }
}
