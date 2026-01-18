<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Change Your Life With A University of Africa Scholarship',
                'description' => 'Complete the following required fields to apply for a scholarship for the programme of your choice.',
                'button_text' => 'LEARN HOW YOU CAN APPLY',
                'button_link' => '/programmes',
                'image_path' => 'slides/slide_68498feeedf82.jpg',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Excellence in Education and Research',
                'description' => 'Join a leading institution committed to academic excellence and groundbreaking research across Africa.',
                'button_text' => 'EXPLORE OUR PROGRAMMES',
                'button_link' => '/programmes',
                'image_path' => 'slides/slide_684993bbef228.jpg',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Transform Your Future with Quality Education',
                'description' => 'Flexible learning opportunities using modern technology, world-class materials, and personal guidance.',
                'button_text' => 'APPLY NOW',
                'button_link' => 'https://keystoneportal.net/newapplicationform.html',
                'image_path' => 'slides/slide_6_1763109602.jpg',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Global Partnerships, Local Impact',
                'description' => 'Collaborate with renowned institutions across the world while making a difference in your community.',
                'button_text' => 'DISCOVER MORE',
                'button_link' => '/about',
                'image_path' => 'slides/slide_7_1763048018.jpg',
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($slides as $slideData) {
            HeroSlide::updateOrCreate(
                ['title' => $slideData['title']],
                $slideData
            );
        }

        $this->command->info('Hero slides seeded successfully!');
    }
}
