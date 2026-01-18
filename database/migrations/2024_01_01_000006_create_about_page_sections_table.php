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
        Schema::create('about_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page_slug'); // who-we-are, vision-mission
            $table->string('section_key'); // vision, mission, stats, timeline, values, features, etc.
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // icon name
            $table->string('color')->nullable(); // gradient color
            $table->json('items')->nullable(); // array of items (highlights, stats values, etc.)
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_sections');
    }
};
