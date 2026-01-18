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
        Schema::create('library_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('type'); // 'Downloadable' or 'Online Access'
            $table->string('category'); // 'ebooks', 'courses', 'research', 'journals', 'multimedia'
            $table->string('image_url')->nullable();
            $table->string('link');
            $table->decimal('rating', 3, 2)->default(0.00); // e.g., 4.8
            $table->string('user_count')->default('0'); // e.g., '2.5M+'
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true); // true for active, false for not working
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_resources');
    }
};
