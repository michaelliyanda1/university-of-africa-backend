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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('graduation_year');
            $table->string('degree');
            $table->string('current_position');
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
