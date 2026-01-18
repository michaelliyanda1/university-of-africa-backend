<?php

namespace Database\Seeders;

use App\Models\PromotionalAd;
use Illuminate\Database\Seeder;

class PromotionalAdSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            [
                'image_path' => '/ads/mphil.jpg',
                'link_url' => 'https://keystoneportal.net/newapplicationform.html',
                'title' => 'Master of Philosophy in Development Studies',
                'description' => 'A course for leaders shaping sustainable development',
                'is_active' => true,
                'order' => 1
            ],
            [
                'image_path' => '/ads/mcom.jpg',
                'link_url' => 'https://keystoneportal.net/newapplicationform.html',
                'title' => 'Master of Commerce',
                'description' => 'Driving entrepreneurship and innovation',
                'is_active' => true,
                'order' => 2
            ],
            [
                'image_path' => '/ads/digitalmk.jpg',
                'link_url' => 'https://keystoneportal.net/newapplicationform.html',
                'title' => 'Digital Marketing Essentials',
                'description' => 'Short course - 100% Online',
                'is_active' => true,
                'order' => 3
            ],
            [
                'image_path' => '/ads/health.jpg',
                'link_url' => 'https://keystoneportal.net/newapplicationform.html',
                'title' => 'Occupational Health & Safety',
                'description' => 'Short course - Professional certificate',
                'is_active' => true,
                'order' => 4
            ],
        ];

        foreach ($ads as $ad) {
            PromotionalAd::create($ad);
        }
    }
}
