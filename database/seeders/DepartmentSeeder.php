<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Computer Science & Information Technology',
                'slug' => 'computer-science-information-technology',
                'code' => 'CSIT',
                'description' => 'The Department of Computer Science & Information Technology offers cutting-edge programs in software development, artificial intelligence, cybersecurity, and data science. Our curriculum is designed to equip students with the technical skills and theoretical knowledge needed to excel in the rapidly evolving tech industry. With state-of-the-art laboratories and experienced faculty, we prepare graduates for careers in software engineering, network administration, database management, and emerging technologies like machine learning and blockchain.',
                'head_of_department' => 'Dr. Sarah Johnson',
                'email' => 'csit@universityofafrica.edu',
                'phone' => '+260-211-1234567',
                'announcements' => [
                    [
                        'title' => 'New AI Lab Opening',
                        'content' => 'We are excited to announce the opening of our state-of-the-art Artificial Intelligence Laboratory on February 1st, 2026. The lab will feature advanced GPU clusters and collaborative workspaces.',
                        'date' => '2026-01-15',
                        'type' => 'event'
                    ],
                    [
                        'title' => 'Hackathon 2026 Registration Open',
                        'content' => 'Annual CSIT Hackathon registration is now open! Join us for 48 hours of coding, innovation, and prizes worth $10,000. Register before January 31st.',
                        'date' => '2026-01-10',
                        'type' => 'announcement'
                    ],
                    [
                        'title' => 'Guest Lecture: Blockchain Technology',
                        'content' => 'Join us for a special guest lecture by Dr. Michael Zhang on "The Future of Blockchain in Africa" on January 25th at 2:00 PM in Lecture Hall A.',
                        'date' => '2026-01-08',
                        'type' => 'event'
                    ]
                ],
                'downloads' => [
                    [
                        'title' => 'CSIT Course Catalog 2026',
                        'description' => 'Complete course listings and descriptions for all CSIT programs',
                        'file_url' => '/downloads/csit-catalog-2026.pdf',
                        'file_size' => '2.5 MB',
                        'file_type' => 'PDF'
                    ],
                    [
                        'title' => 'Lab Access Request Form',
                        'description' => 'Form for requesting access to computer labs and specialized equipment',
                        'file_url' => '/downloads/lab-access-form.pdf',
                        'file_size' => '156 KB',
                        'file_type' => 'PDF'
                    ],
                    [
                        'title' => 'Programming Style Guide',
                        'description' => 'Department coding standards and best practices guide',
                        'file_url' => '/downloads/programming-style-guide.pdf',
                        'file_size' => '890 KB',
                        'file_type' => 'PDF'
                    ]
                ],
                'news_links' => [
                    [
                        'title' => 'CSIT Students Win National Coding Competition',
                        'url' => '/news/csit-students-win-national-competition',
                        'date' => '2026-01-12',
                        'excerpt' => 'Three of our students took top honors at the National Coding Championship'
                    ],
                    [
                        'title' => 'New Partnership with Tech Giants',
                        'url' => '/news/tech-partnership-announcement',
                        'date' => '2026-01-05',
                        'excerpt' => 'Department announces collaboration with leading technology companies for internship programs'
                    ]
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Business Administration & Management',
                'slug' => 'business-administration-management',
                'code' => 'BAM',
                'description' => 'Our Business Administration & Management Department provides comprehensive education in leadership, finance, marketing, and entrepreneurship. Students learn modern business practices, strategic management, and organizational behavior through case studies and real-world projects. Our programs emphasize practical skills, ethical leadership, and global business perspectives, preparing graduates for management roles in multinational corporations, startups, and government organizations.',
                'head_of_department' => 'Prof. Michael Chen',
                'email' => 'bam@universityofafrica.edu',
                'phone' => '+260-211-1234568',
                'announcements' => [
                    [
                        'title' => 'Entrepreneurship Workshop Series',
                        'content' => 'Join our 6-week workshop series on starting and scaling businesses in Africa. Sessions every Thursday at 4:00 PM starting January 20th.',
                        'date' => '2026-01-14',
                        'type' => 'workshop'
                    ],
                    [
                        'title' => 'MBA Information Session',
                        'content' => 'Learn about our Executive MBA program designed for working professionals. Virtual session on January 28th at 6:00 PM.',
                        'date' => '2026-01-11',
                        'type' => 'info_session'
                    ]
                ],
                'downloads' => [
                    [
                        'title' => 'Business Program Brochure',
                        'description' => 'Overview of all business programs and specializations',
                        'file_url' => '/downloads/business-brochure-2026.pdf',
                        'file_size' => '3.2 MB',
                        'file_type' => 'PDF'
                    ],
                    [
                        'title' => 'Internship Guidelines',
                        'description' => 'Requirements and procedures for business internships',
                        'file_url' => '/downloads/internship-guidelines.pdf',
                        'file_size' => '450 KB',
                        'file_type' => 'PDF'
                    ]
                ],
                'news_links' => [
                    [
                        'title' => 'BAM Students Launch Successful Startup',
                        'url' => '/news/student-startup-success',
                        'date' => '2026-01-09',
                        'excerpt' => 'Alumni-founded company secures $500K in seed funding'
                    ]
                ],
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Education & Teacher Training',
                'slug' => 'education-teacher-training',
                'code' => 'EDU',
                'description' => 'The Education Department is committed to producing exceptional educators who can inspire and transform learning environments. Our programs combine pedagogical theory with practical teaching experience, covering early childhood education, primary and secondary teaching, special education, and educational leadership. Students benefit from our partnerships with local schools and innovative teaching methodologies that prepare them for diverse educational settings.',
                'head_of_department' => 'Dr. Elizabeth Mwangi',
                'email' => 'education@universityofafrica.edu',
                'phone' => '+260-211-1234569',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Engineering & Technology',
                'slug' => 'engineering-technology',
                'code' => 'ENG',
                'description' => 'Our Engineering Department offers programs in civil, mechanical, electrical, and environmental engineering. With a focus on sustainable design and innovation, students engage in hands-on projects, laboratory work, and industry partnerships. Our curriculum emphasizes problem-solving, design thinking, and the application of engineering principles to address real-world challenges in infrastructure development, renewable energy, and technological advancement.',
                'head_of_department' => 'Dr. James Okonkwo',
                'email' => 'engineering@universityofafrica.edu',
                'phone' => '+260-211-1234570',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Health Sciences & Nursing',
                'slug' => 'health-sciences-nursing',
                'code' => 'HSN',
                'description' => 'The Health Sciences Department prepares healthcare professionals through programs in nursing, public health, medical laboratory technology, and health administration. Our curriculum combines theoretical knowledge with extensive clinical practice, ensuring graduates are ready to meet the healthcare needs of communities. We emphasize evidence-based practice, patient-centered care, and the development of leadership skills in healthcare management.',
                'head_of_department' => 'Dr. Grace Mbewe',
                'email' => 'health@universityofafrica.edu',
                'phone' => '+260-211-1234571',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Social Sciences & Humanities',
                'slug' => 'social-sciences-humanities',
                'code' => 'SSH',
                'description' => 'Our Social Sciences & Humanities Department explores human behavior, society, culture, and communication. Programs include psychology, sociology, international relations, literature, and philosophy. Students develop critical thinking, research skills, and cultural awareness through interdisciplinary studies and community engagement. Our graduates are prepared for careers in social work, public policy, journalism, and cultural preservation.',
                'head_of_department' => 'Prof. David Thompson',
                'email' => 'socialsciences@universityofafrica.edu',
                'phone' => '+260-211-1234572',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Agriculture & Environmental Sciences',
                'slug' => 'agriculture-environmental-sciences',
                'code' => 'AES',
                'description' => 'The Agriculture & Environmental Sciences Department focuses on sustainable farming practices, food security, and environmental conservation. Our programs cover agronomy, animal science, agricultural economics, and environmental management. Students engage in practical fieldwork, research projects, and community outreach programs that address agricultural challenges and promote environmental stewardship in the African context.',
                'head_of_department' => 'Dr. Samuel Kafwamba',
                'email' => 'agriculture@universityofafrica.edu',
                'phone' => '+260-211-1234573',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Law & Legal Studies',
                'slug' => 'law-legal-studies',
                'code' => 'LAW',
                'description' => 'Our Law Department provides comprehensive legal education covering constitutional law, commercial law, international law, and human rights. Students develop analytical skills, legal research capabilities, and ethical reasoning through moot court competitions, legal clinics, and internships. Our programs prepare graduates for careers in legal practice, judiciary, corporate law, and public service, with emphasis on justice and rule of law.',
                'head_of_department' => 'Justice Patricia Mumba',
                'email' => 'law@universityofafrica.edu',
                'phone' => '+260-211-1234574',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'name' => 'Mathematics & Statistics',
                'slug' => 'mathematics-statistics',
                'code' => 'MAS',
                'description' => 'The Mathematics & Statistics Department offers programs in pure mathematics, applied mathematics, and statistical analysis. Our curriculum emphasizes mathematical reasoning, problem-solving, and data analysis techniques that are essential for scientific research, financial modeling, and technological innovation. Students engage in theoretical studies and practical applications that prepare them for careers in academia, research institutions, and data-driven industries.',
                'head_of_department' => 'Dr. Robert Nkonde',
                'email' => 'mathematics@universityofafrica.edu',
                'phone' => '+260-211-1234575',
                'is_active' => true,
                'order' => 9,
            ],
            [
                'name' => 'Media & Communication Studies',
                'slug' => 'media-communication-studies',
                'code' => 'MCS',
                'description' => 'Our Media & Communication Department prepares students for careers in journalism, digital media, public relations, and corporate communication. Programs cover media theory, content creation, digital marketing, and strategic communication. Students gain hands-on experience through media production labs, internship programs, and community media projects, developing skills in storytelling, media analysis, and ethical communication practices.',
                'head_of_department' => 'Dr. Amanda Banda',
                'email' => 'media@universityofafrica.edu',
                'phone' => '+260-211-1234576',
                'is_active' => true,
                'order' => 10,
            ],
        ];

        foreach ($departments as $deptData) {
            Department::updateOrCreate(
                ['slug' => $deptData['slug']],
                $deptData
            );
        }

        $this->command->info('Department dummy data seeded successfully!');
    }
}
