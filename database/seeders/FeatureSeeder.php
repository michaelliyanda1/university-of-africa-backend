<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'title' => 'Flexible Learning',
                'description' => 'Study at your own pace with modern technology, world-class materials and personal guidance.',
                'icon' => 'BookOpen',
                'color_from' => 'blue-500',
                'color_to' => 'blue-600',
                'icon_bg' => 'bg-blue-100',
                'icon_color' => 'text-blue-600',
                'is_active' => true,
                'order' => 1
            ],
            [
                'title' => 'Fast-Track Options',
                'description' => 'Upgrade diplomas to bachelor degrees within 2 years through academic recognition.',
                'icon' => 'TrendingUp',
                'color_from' => 'green-500',
                'color_to' => 'green-600',
                'icon_bg' => 'bg-green-100',
                'icon_color' => 'text-green-600',
                'is_active' => true,
                'order' => 2
            ],
            [
                'title' => 'Affordable Excellence',
                'description' => 'Lower costs with scholarships available and easy monthly payment systems.',
                'icon' => 'Award',
                'color_from' => 'purple-500',
                'color_to' => 'purple-600',
                'icon_bg' => 'bg-purple-100',
                'icon_color' => 'text-purple-600',
                'is_active' => true,
                'order' => 3
            ],
            [
                'title' => 'Continental Reach',
                'description' => 'Accredited qualifications from diploma to doctorate level, recognized across Africa.',
                'icon' => 'Globe',
                'color_from' => 'orange-500',
                'color_to' => 'orange-600',
                'icon_bg' => 'bg-orange-100',
                'icon_color' => 'text-orange-600',
                'is_active' => true,
                'order' => 4
            ],
            [
                'title' => 'Continuous Registration',
                'description' => 'Start anytime during the year with 4 exam sessions annually for maximum flexibility.',
                'icon' => 'Users',
                'color_from' => 'pink-500',
                'color_to' => 'pink-600',
                'icon_bg' => 'bg-pink-100',
                'icon_color' => 'text-pink-600',
                'is_active' => true,
                'order' => 5
            ],
            [
                'title' => 'Modular Learning',
                'description' => 'Modular study materials and assessment with a complete library at home.',
                'icon' => 'GraduationCap',
                'color_from' => 'indigo-500',
                'color_to' => 'indigo-600',
                'icon_bg' => 'bg-indigo-100',
                'icon_color' => 'text-indigo-600',
                'is_active' => true,
                'order' => 6
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
