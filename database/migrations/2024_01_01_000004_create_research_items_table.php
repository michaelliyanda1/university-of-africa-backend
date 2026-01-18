<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('abstract');
            $table->json('authors');
            $table->json('keywords')->nullable();
            $table->foreignId('collection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size');
            $table->string('file_type')->default('application/pdf');
            $table->date('publication_date')->nullable();
            $table->string('doi')->nullable();
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'created_at']);
            $table->index('collection_id');
            $table->fullText(['title', 'abstract']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_items');
    }
};
