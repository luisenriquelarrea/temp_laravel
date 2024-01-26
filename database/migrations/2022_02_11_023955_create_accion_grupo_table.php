<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccionGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accion_grupo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accion_id')->nullable();
            $table->unsignedBigInteger('grupo_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['accion_id', 'grupo_id']);
            $table->foreign('accion_id')
                ->references('id')
                ->on('accion')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('grupo_id')
                ->references('id')
                ->on('grupo')
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
        Schema::dropIfExists('accion_grupo');
    }
}
