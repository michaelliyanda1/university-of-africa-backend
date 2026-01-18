<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('category')->default('General News');
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->integer('views')->default(0);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'published_at']);
            $table->fullText(['title', 'excerpt', 'content']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
