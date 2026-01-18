<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Virtual Campus Tour of University of Africa',
                'description' => 'Take an exclusive journey into the vibrant life of a University of Africa student. Join us on a thrilling 360° virtual tour.',
                'caption' => 'Explore our state-of-the-art facilities and campus life',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'is_active' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Student Success Stories',
                'description' => 'Hear from our graduates about how University of Africa transformed their careers and lives.',
                'caption' => 'Real stories from real students achieving excellence',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Research & Innovation at UOA',
                'description' => 'Discover groundbreaking research and innovation happening at the University of Africa.',
                'caption' => 'Leading research that shapes the future of Africa',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'is_active' => true,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Academic Excellence',
                'description' => 'Learn about our world-class academic programmes and distinguished faculty members.',
                'caption' => 'Quality education that prepares you for global success',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'is_active' => true,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('videos')->insert($videos);
    }
}
