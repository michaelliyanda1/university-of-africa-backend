<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location')->default('header');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('navigation_menus')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->onDelete('cascade');
            $table->string('label');
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->string('icon')->nullable();
            $table->string('target')->default('_self');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('permissions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('navigation_menus');
    }
};
