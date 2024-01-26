<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccionBasicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accion_basica', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable()->unique();
            $table->string('call_method')->nullable();
            $table->string('label')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('on_navbar')->default(false);
            $table->boolean('on_table')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accion_basica');
    }
}
