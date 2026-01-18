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
        Schema::create('alumni_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained()->onDelete('cascade');
            $table->string('alumni_name');
            $table->string('position');
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->integer('likes')->default(0);
            $table->integer('comments')->default(0);
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
        Schema::dropIfExists('alumni_testimonials');
    }
};
