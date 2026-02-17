<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sat_download_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sat_download_request_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('package_id');
            $table->string('status')->default('pending'); 
            // pending | downloaded | failed

            $table->text('error_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sat_download_packages');
    }
};
