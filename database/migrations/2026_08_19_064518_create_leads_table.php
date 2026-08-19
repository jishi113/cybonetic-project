<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->nullable()
                  ->constrained('companies')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()
                  ->constrained('users')->nullOnDelete();

            $table->string('title', 200);
            $table->string('contact_name', 100);
            $table->string('contact_email', 150)->nullable();
            $table->string('contact_phone', 20)->nullable();

            $table->enum('source', ['website','referral','cold_call','social','event','other'])
                  ->default('other');
            $table->enum('status', ['new','contacted','qualified','proposal','negotiation','won','lost'])
                  ->default('new');

            $table->decimal('value', 12, 2)->default(0);
            $table->date('expected_close')->nullable();
            $table->text('notes')->nullable();
            $table->string('lost_reason')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('assigned_to');
            $table->index('expected_close');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};