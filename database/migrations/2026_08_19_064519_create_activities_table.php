<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lead_id')
                  ->constrained('leads')->cascadeOnDelete();
            $table->foreignId('user_id')
                  ->constrained('users')->cascadeOnDelete();

            $table->enum('type', ['call','email','meeting','demo','follow_up','note']);
            $table->string('subject', 200);
            $table->text('description')->nullable();
            $table->timestamp('occurred_at')->useCurrent();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};