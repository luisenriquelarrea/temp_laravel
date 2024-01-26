<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoPostalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_postal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipio')
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
        Schema::dropIfExists('codigo_postal');
    }
}
