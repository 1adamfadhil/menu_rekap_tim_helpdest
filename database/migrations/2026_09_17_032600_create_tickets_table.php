<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_number')->unique();

            // User yang membuat tiket
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Agent yang menangani tiket
            // Nullable karena tiket baru belum tentu langsung punya agent
            $table->foreignId('agent_id')
                ->nullable();

            $table->foreign('agent_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            // Kategori tiket
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('title');
            $table->text('description');

            $table->string('priority')->default('medium');
            $table->string('status')->default('open');

            $table->string('attachment')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
