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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade');
            $table->string('isbn', 50)->unique();
            $table->text('description')->nullable();
            $table->date('published_at')->nullable();
            $table->unsignedInteger('pages')->nullable();
            $table->timestamps();

            // Indexes for frequently filtered columns
            $table->index('author_id');
            $table->index('publisher_id');
            $table->index('isbn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
