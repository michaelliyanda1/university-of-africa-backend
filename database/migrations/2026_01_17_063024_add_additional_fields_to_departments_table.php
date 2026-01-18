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
        Schema::table('departments', function (Blueprint $table) {
            $table->string('featured_image')->nullable()->after('image');
            $table->json('announcements')->nullable()->after('description');
            $table->json('downloads')->nullable()->after('announcements');
            $table->json('news_links')->nullable()->after('downloads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['featured_image', 'announcements', 'downloads', 'news_links']);
        });
    }
};
