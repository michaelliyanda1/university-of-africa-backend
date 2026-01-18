<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'student_name' => 'John Phiri',
                'student_image' => 'https://via.placeholder.com/150/1C60A4/FFFFFF?text=JP',
                'programme' => 'Bachelor of Computer Science',
                'graduation_year' => '2024',
                'testimonial' => 'The practical approach to learning and supportive faculty helped me build the skills I needed to succeed in the tech industry. Highly recommended!',
                'current_position' => 'Software Developer, Tech Solutions Ltd',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1
            ],
            [
                'student_name' => 'Sarah Mwamba',
                'student_image' => 'https://via.placeholder.com/150/4E90FE/FFFFFF?text=SM',
                'programme' => 'MBA - Strategy & Leadership',
                'graduation_year' => '2023',
                'testimonial' => 'The University of Africa transformed my career. The flexible learning approach allowed me to study while working, and the quality of education exceeded my expectations.',
                'current_position' => 'Senior Manager, ABC Corporation',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2
            ],
            [
                'student_name' => 'Grace Banda',
                'student_image' => 'https://via.placeholder.com/150/1C60A4/FFFFFF?text=GB',
                'programme' => 'Master of Education',
                'graduation_year' => '2024',
                'testimonial' => 'As a working teacher, the distance learning model was perfect for me. The programme enhanced my teaching skills and opened new career opportunities.',
                'current_position' => 'School Principal, Green Valley School',
                'is_featured' => true,
                'is_active' => true,
                'order' => 3
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
