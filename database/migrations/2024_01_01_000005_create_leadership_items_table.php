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
        Schema::create('leadership_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('category'); // executive, academic, administrative
            $table->text('bio');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->json('expertise')->nullable(); // array of expertise areas
            $table->json('achievements')->nullable(); // array of achievements
            $table->string('quote')->nullable();
            $table->string('image')->nullable(); // image path
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
        Schema::dropIfExists('leadership_items');
    }
};
