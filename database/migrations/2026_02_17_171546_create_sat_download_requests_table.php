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
        Schema::create('sat_download_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->nullable();
            $table->timestamp('date_from');
            $table->timestamp('date_to');

            $table->string('status')->default('created'); 
            // created | accepted | in_progress | finished | completed | failed | rejected

            $table->integer('packages_count')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->timestamp('last_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sat_download_requests');
    }
};
