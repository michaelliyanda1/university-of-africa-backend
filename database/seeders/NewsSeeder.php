<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'System Administrator',
                'email' => 'admin@universityofafrica.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]);
        }

        $news = [
            [
                'title' => 'Global Partnerships',
                'slug' => 'global-partnerships',
                'excerpt' => 'Collaboration without Borders We partner with world-leading institutions to co-create knowledge and expand opportunities for African researchers and students.',
                'content' => '<p>The University of Africa is proud to announce new partnerships with leading institutions across the globe. These collaborations will create unprecedented opportunities for our students and researchers.</p><p>Together, we break barriers and push global frontiers in education and research.</p>',
                'featured_image' => '/news/news_6849302e6e6fb.jpg',
                'category' => 'General News',
                'author_id' => $user->id,
                'views' => 43,
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Online Exam Set to Begin This Dec 2025',
                'slug' => 'online-exam-set-to-begin-dec-2025',
                'excerpt' => 'The much-anticipated online exams are scheduled to start this December 16th, 2025. This is an important milestone as we transition to a more flexible examination system.',
                'content' => '<p>We are excited to announce that our online examination system will launch in December 2025. This new system provides greater flexibility for our distance learning students.</p><p>Students will be able to take exams from anywhere, making education more accessible than ever.</p>',
                'featured_image' => '/news/news_68494af8b2627.jpg',
                'category' => 'Events',
                'author_id' => $user->id,
                'views' => 29,
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Beware of Cyber Hacks Through Malicious Links',
                'slug' => 'beware-cyber-hacks-malicious-links',
                'excerpt' => 'Cybercriminals are exploiting popular messaging platforms such as Telegram, WhatsApp, Facebook, and Twitter by spreading malicious links under the guise of legitimate communications.',
                'content' => '<p>The University of Africa IT Security team warns all students and staff about increasing cyber threats through malicious links.</p><p>Please be vigilant when clicking on links received through social media and messaging platforms. Always verify the source before clicking.</p><p>If you receive suspicious messages claiming to be from the university, please report them to our IT Help Desk immediately.</p>',
                'featured_image' => null,
                'category' => 'General News',
                'author_id' => $user->id,
                'views' => 26,
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($news as $article) {
            News::create($article);
        }
    }
}
