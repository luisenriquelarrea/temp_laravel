<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionMenuInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccion_menu_input', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seccion_menu_id')->nullable();
            $table->string('input_type')->nullable();
            $table->string('input_label')->nullable();
            $table->string('input_id')->nullable();
            $table->string('input_name')->nullable();
            $table->integer('input_cols')->nullable();
            $table->boolean('input_required')->default(false);
            $table->boolean('alta')->default(false);
            $table->boolean('modifica')->default(false);
            $table->boolean('lista')->default(false);
            $table->boolean('filtro')->default(false);
            $table->integer('orden')->nullable();
            $table->string('modelo')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
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
        Schema::dropIfExists('seccion_menu_input');
    }
}
