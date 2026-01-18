<?php

namespace Database\Seeders;

use App\Models\HomepageSetting;
use Illuminate\Database\Seeder;

class HomepageSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'students_enrolled',
                'label' => 'Students Enrolled',
                'value' => '10,000+',
                'type' => 'text',
                'description' => 'Number of students enrolled statistic',
            ],
            [
                'key' => 'research_papers',
                'label' => 'Research Papers',
                'value' => '5,000+',
                'type' => 'text',
                'description' => 'Number of research papers statistic',
            ],
            [
                'key' => 'faculty_members',
                'label' => 'Faculty Members',
                'value' => '500+',
                'type' => 'text',
                'description' => 'Number of faculty members statistic',
            ],
            [
                'key' => 'partner_universities',
                'label' => 'Partner Universities',
                'value' => '50+',
                'type' => 'text',
                'description' => 'Number of partner universities statistic',
            ],
        ];

        foreach ($settings as $setting) {
            HomepageSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Homepage settings seeded successfully!');
    }
}
