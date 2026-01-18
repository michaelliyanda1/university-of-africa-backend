<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('level', ['diploma', 'undergraduate', 'postgraduate']);
            $table->string('school');
            $table->string('duration');
            $table->string('mode');
            $table->text('description');
            $table->longText('full_description');
            $table->json('specializations')->nullable();
            $table->text('entry_requirements');
            $table->json('careers');
            $table->json('learning_outcomes');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programmes');
    }
};
