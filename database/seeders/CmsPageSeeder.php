<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\User;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        $pages = [
            [
                'title' => 'Library Services',
                'slug' => 'library-services',
                'content' => '<h1>Digital Library Resources</h1><p>Access a wealth of digital resources to support your academic journey</p>',
                'meta_title' => 'Library Services - University of Africa',
                'meta_description' => 'Access digital library resources and academic materials',
                'status' => 'published',
                'created_by' => $admin?->id ?? 1,
                'published_at' => now(),
            ],
            [
                'title' => 'Forms & Downloads',
                'slug' => 'forms-downloads',
                'content' => '<h1>Forms & Downloads</h1><p>Download important forms and documents for your academic needs</p>',
                'meta_title' => 'Forms & Downloads - University of Africa',
                'meta_description' => 'Download academic forms and important documents',
                'status' => 'published',
                'created_by' => $admin?->id ?? 1,
                'published_at' => now(),
            ],
        ];

        foreach ($pages as $pageData) {
            CmsPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        $this->command->info('CMS pages seeded successfully!');
    }
}
