<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumni;
use App\Models\AlumniTestimonial;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample alumni
        $alumni1 = Alumni::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@example.com',
            'phone' => '+234-801-234-5678',
            'graduation_year' => 2015,
            'degree' => 'Bachelor of Business Administration',
            'current_position' => 'Senior Manager',
            'company' => 'Deloitte Nigeria',
            'location' => 'Lagos, Nigeria',
            'linkedin_url' => 'https://linkedin.com/in/sarahjohnson',
            'bio' => 'After graduating from UOA, I joined Deloitte where I have grown from a junior consultant to a Senior Manager. The foundation I received at UOA was instrumental in my career success.',
            'is_featured' => true,
            'approved' => true,
            'approved_at' => now(),
            'order' => 1
        ]);

        $alumni2 = Alumni::create([
            'name' => 'Michael Chen',
            'email' => 'michael.chen@example.com',
            'phone' => '+234-802-345-6789',
            'graduation_year' => 2018,
            'degree' => 'Master of Computer Science',
            'current_position' => 'Software Engineering Lead',
            'company' => 'Microsoft',
            'location' => 'Redmond, USA',
            'linkedin_url' => 'https://linkedin.com/in/michaelchen',
            'bio' => 'UOA\'s computer science program prepared me for the challenges of working at one of the world\'s leading tech companies. I\'m proud to be a UOA graduate making impact globally.',
            'approved' => true,
            'approved_at' => now(),
            'order' => 2
        ]);

        $alumni3 = Alumni::create([
            'name' => 'Amaka Okafor',
            'email' => 'amaka.okafor@example.com',
            'phone' => '+234-803-456-7890',
            'graduation_year' => 2016,
            'degree' => 'Bachelor of Medicine',
            'current_position' => 'Consultant Physician',
            'company' => 'Lagos University Teaching Hospital',
            'location' => 'Lagos, Nigeria',
            'bio' => 'The medical training I received at UOA was exceptional. Today, I serve my community as a consultant physician, saving lives every day.',
            'approved' => true,
            'approved_at' => now(),
            'order' => 3
        ]);

        $alumni4 = Alumni::create([
            'name' => 'James Williams',
            'email' => 'james.williams@example.com',
            'phone' => '+234-804-567-8901',
            'graduation_year' => 2019,
            'degree' => 'Bachelor of Engineering',
            'current_position' => 'Project Manager',
            'company' => 'Shell Nigeria',
            'location' => 'Port Harcourt, Nigeria',
            'bio' => 'UOA\'s engineering program provided me with the skills and knowledge to excel in the oil and gas industry. I\'m grateful for the quality education I received.',
            'approved' => true,
            'approved_at' => now(),
            'order' => 4
        ]);

        $alumni5 = Alumni::create([
            'name' => 'Fatima Abdullahi',
            'email' => 'fatima.abdullahi@example.com',
            'phone' => '+234-805-678-9012',
            'graduation_year' => 2017,
            'degree' => 'Bachelor of Law',
            'current_position' => 'Senior Associate',
            'company' => 'Aluko & Ogunbadeju',
            'location' => 'Abuja, Nigeria',
            'bio' => 'UOA\'s law program prepared me for the rigors of legal practice. I now specialize in corporate law and help businesses navigate complex legal challenges.',
            'approved' => true,
            'approved_at' => now(),
            'order' => 5
        ]);

        // Create testimonials
        AlumniTestimonial::create([
            'alumni_id' => $alumni1->id,
            'alumni_name' => 'Dr. Sarah Johnson',
            'position' => 'Senior Manager at Deloitte Nigeria',
            'content' => 'UOA provided me with not just academic knowledge, but also the leadership skills and confidence needed to excel in the corporate world. The diverse student body and experienced faculty created an environment that fostered growth and innovation.',
            'rating' => 5,
            'approved' => true,
            'approved_at' => now(),
            'order' => 1
        ]);

        AlumniTestimonial::create([
            'alumni_id' => $alumni2->id,
            'alumni_name' => 'Michael Chen',
            'position' => 'Software Engineering Lead at Microsoft',
            'content' => 'The computer science program at UOA was rigorous and comprehensive. It prepared me well for the challenges of working in a global tech company. I\'m particularly grateful for the practical projects and internship opportunities.',
            'rating' => 5,
            'approved' => true,
            'approved_at' => now(),
            'order' => 2
        ]);

        AlumniTestimonial::create([
            'alumni_id' => $alumni3->id,
            'alumni_name' => 'Amaka Okafor',
            'position' => 'Consultant Physician',
            'content' => 'The medical training at UOA was exceptional. The combination of theoretical knowledge and practical experience prepared me for the challenges of medical practice. I\'m proud to serve my community as a healthcare professional.',
            'rating' => 5,
            'approved' => true,
            'approved_at' => now(),
            'order' => 3
        ]);
    }
}
