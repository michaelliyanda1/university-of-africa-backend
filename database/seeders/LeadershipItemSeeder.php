<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadershipItem;

class LeadershipItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaders = [
            [
                'name' => 'Dr. Frank Sakanya',
                'title' => 'Deputy Vice Chancellor Academics',
                'category' => 'executive',
                'bio' => 'Dr. Frank Sakanya brings over 20 years of academic leadership experience, driving excellence in teaching and research across the university.',
                'email' => 'frank.sakanya@uoafrik.com',
                'phone' => '+260 97 1234567',
                'linkedin' => 'https://linkedin.com/in/frank-sakanya',
                'twitter' => 'https://twitter.com/frank_sakanya',
                'expertise' => ['Academic Strategy', 'Research Leadership', 'Curriculum Development', 'Quality Assurance'],
                'achievements' => ['20+ Years Experience', '50+ Research Papers', 'International Speaker', 'Award Winner'],
                'quote' => 'Education is the most powerful tool for transforming Africa\'s future.',
                'image' => null, // Will need to upload actual image
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Mr. Kakoma Chipoya',
                'title' => 'Chief Financial Officer',
                'category' => 'executive',
                'bio' => 'Mr. Kakoma Chipoya is a seasoned financial strategist with extensive experience in higher education financial management and sustainable growth.',
                'email' => 'kakoma.chipoya@uoafrik.com',
                'phone' => '+260 97 2345678',
                'linkedin' => 'https://linkedin.com/in/kakoma-chipoya',
                'twitter' => 'https://twitter.com/kakoma_chipoya',
                'expertise' => ['Financial Strategy', 'Budget Management', 'Investment Planning', 'Risk Assessment'],
                'achievements' => ['15+ Years Experience', 'CFA Certified', 'Growth Strategist', 'Financial Innovator'],
                'quote' => 'Sound financial management is the foundation of sustainable academic excellence.',
                'image' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Naomi Katongo',
                'title' => 'Deputy Vice Chancellor',
                'category' => 'executive',
                'bio' => 'Naomi Katongo leads strategic initiatives and institutional development, fostering innovation and excellence across all university operations.',
                'email' => 'naomi.katongo@uoafrik.com',
                'phone' => '+260 97 3456789',
                'linkedin' => 'https://linkedin.com/in/naomi-katongo',
                'twitter' => 'https://twitter.com/naomi_katongo',
                'expertise' => ['Strategic Planning', 'Institutional Development', 'Policy Development', 'Stakeholder Relations'],
                'achievements' => ['Leadership Excellence', 'Policy Expert', 'Strategic Visionary', 'Change Agent'],
                'quote' => 'Strategic leadership is about creating pathways for others to succeed and excel.',
                'image' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Prof. Sarah Mwamba',
                'title' => 'Dean of Research',
                'category' => 'academic',
                'bio' => 'Prof. Sarah Mwamba is a distinguished researcher and academic leader, championing cutting-edge research and innovation across disciplines.',
                'email' => 'sarah.mwamba@uoafrik.com',
                'phone' => '+260 97 4567890',
                'linkedin' => 'https://linkedin.com/in/sarah-mwamba',
                'twitter' => 'https://twitter.com/sarah_mwamba',
                'expertise' => ['Research Management', 'Academic Innovation', 'Grant Writing', 'Mentorship'],
                'achievements' => ['100+ Publications', 'Research Grants', 'Mentor Award', 'Innovation Leader'],
                'quote' => 'Research is the engine that drives academic excellence and societal impact.',
                'image' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($leaders as $leader) {
            LeadershipItem::create($leader);
        }
    }
}
