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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // (required)
            $table->integer('user_id');
            $table->string('status')->default('pending'); // (pending, in_progress, done)
            $table->string('description')->nullable(); // (optional)
            $table->date('due_date')->nullable();// (optional)
            $table->softDeletes(); // soft delete
            $table->timestamps();

            $table->index('title');
            $table->index('user_id');
            $table->index('status');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
