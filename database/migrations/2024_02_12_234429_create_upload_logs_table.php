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
        Schema::create('upload_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->foreignId('user_id');
            $table->enum('status', ['successful', 'warnings']);
            $table->ipAddress()->nullable();
            $table->text('user_agent')->nullable();
            $table->json('data');
            $table->timestamps();

            $table->index('job_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_logs');
    }
};
