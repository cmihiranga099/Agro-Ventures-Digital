<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->index();
            $table->enum('priority', ['low', 'medium', 'high'])->index();
            $table->date('due_date')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
