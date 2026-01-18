<?php

namespace Database\Seeders;

use App\Models\Programme;
use Illuminate\Database\Seeder;

class ProgrammeSeeder extends Seeder
{
    public function run(): void
    {
        $programmes = [
            [
                'title' => 'Bachelor of Business Administration',
                'slug' => 'bachelor-business-administration',
                'level' => 'undergraduate',
                'school' => 'business',
                'duration' => '4 years (2 years fast-track)',
                'mode' => 'Distance Learning',
                'description' => 'Excellent qualification for aspiring middle and senior management positions with specializations available.',
                'full_description' => 'The Bachelor of Business Administration covers a wide range of disciplines that provide solid general knowledge to be a competent manager in private or public organizations.',
                'specializations' => ['Business Management', 'Project Management', 'Financial Management', 'Marketing Management', 'Economics & Finances', 'Human Resource Management', 'Purchasing & Supply Management', 'Security & Risk Management', 'Corporate Risk & Security Management'],
                'entry_requirements' => 'Full Grade 12 Certificate OR Diploma (Fast-track option available)',
                'careers' => ['Business Manager', 'Project Manager', 'Financial Manager', 'Marketing Manager', 'HR Manager'],
                'learning_outcomes' => ['Develop strategic management understanding', 'Master functional disciplines', 'Build ethical corporate governance awareness'],
                'is_featured' => true,
                'order' => 1
            ],
            [
                'title' => 'Master of Business Administration (MBA)',
                'slug' => 'master-business-administration-mba',
                'level' => 'postgraduate',
                'school' => 'postgraduate',
                'duration' => '2 years',
                'mode' => 'Tutored / Distance Learning',
                'description' => 'Advanced business leadership programme with 5 specialization options for strategic management excellence.',
                'full_description' => 'The MBA equips students with practical skills to acquire, interpret, understand, and apply strategic and general management principles.',
                'specializations' => ['Strategy & Leadership', 'Economics', 'Financial Management', 'Marketing Management', 'Human Resources Management'],
                'entry_requirements' => 'Bachelor degree in any field with relevant work experience',
                'careers' => ['Senior Manager', 'CEO', 'Strategy Consultant', 'Business Director'],
                'learning_outcomes' => ['Apply strategic management in complex contexts', 'Work with diverse stakeholders', 'Conduct advanced research'],
                'is_featured' => true,
                'order' => 2
            ],
            [
                'title' => 'Master of Commerce in Development, Innovation & Entrepreneurship',
                'slug' => 'master-commerce-development-innovation-entrepreneurship',
                'level' => 'postgraduate',
                'school' => 'postgraduate',
                'duration' => '2 years',
                'mode' => 'Tutored',
                'description' => 'Designed for aspiring entrepreneurs with 6 specialized tracks including ESG Finance, Digital Business, and Green Innovation.',
                'full_description' => 'This program provides essential entrepreneurial skills and fosters an innovative mindset with focus on SMEs.',
                'specializations' => ['Entrepreneurship & Innovation', 'ESG Finance', 'Corporate & Global Innovation', 'Sustainable Supply Chain', 'E-Commerce & Digital Business', 'Green Innovation'],
                'entry_requirements' => 'Bachelor degree in business or related field',
                'careers' => ['Entrepreneur', 'Innovation Manager', 'Sustainability Consultant'],
                'learning_outcomes' => ['Develop entrepreneurial mindset', 'Master innovation strategies'],
                'is_featured' => true,
                'order' => 3
            ],
            [
                'title' => 'Master of Philosophy in Development Studies',
                'slug' => 'mphil-development-studies',
                'level' => 'postgraduate',
                'school' => 'postgraduate',
                'duration' => '2 years',
                'mode' => 'Research-based',
                'description' => 'Advanced research degree with 10 specialization areas including Climate Change, Natural Resources, and Digital Development.',
                'full_description' => 'The MPhil is an interdisciplinary field examining social, economic, political, technological, and cultural dimensions of societal change.',
                'specializations' => ['Climate Change Adaptation', 'Natural Resources Management', 'Water Resources & WASH', 'Agricultural Development', 'Energy & Infrastructure', 'Digital Development', 'Urban Development', 'Public Health Systems', 'Extractive Industries', 'Peace & Governance'],
                'entry_requirements' => 'Bachelor degree with strong academic record',
                'careers' => ['Development Researcher', 'Policy Analyst', 'Program Manager', 'Development Consultant'],
                'learning_outcomes' => ['Conduct advanced research', 'Analyze development challenges', 'Develop policy solutions'],
                'is_featured' => true,
                'order' => 4
            ],
            [
                'title' => 'Diploma in Accounting',
                'slug' => 'diploma-accounting',
                'level' => 'diploma',
                'school' => 'business',
                'duration' => '2 years',
                'mode' => 'Distance Learning',
                'description' => 'Professional accounting qualification with practical bookkeeping and financial reporting skills.',
                'full_description' => 'Focused course designed to develop specific skills for career readiness in accounting and finance.',
                'specializations' => [],
                'entry_requirements' => 'Full Grade 12 Certificate with Mathematics and English',
                'careers' => ['Accountant', 'Bookkeeper', 'Tax Consultant', 'Financial Assistant'],
                'learning_outcomes' => ['Prepare financial statements', 'Manage bookkeeping systems', 'Understand taxation'],
                'is_featured' => false,
                'order' => 5
            ],
        ];

        foreach ($programmes as $programme) {
            Programme::create($programme);
        }
    }
}
