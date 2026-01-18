<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LibraryResource;

class LibraryResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            [
                'title' => 'Project Gutenberg',
                'description' => 'Over 70,000 free eBooks including classic literature, philosophy, and historical texts',
                'type' => 'Downloadable',
                'category' => 'ebooks',
                'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop',
                'link' => 'https://www.gutenberg.org/',
                'rating' => 4.8,
                'user_count' => '2.5M+',
                'featured' => true,
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'MIT OpenCourseWare',
                'description' => 'Free course materials from MIT including lecture notes, exams, and videos',
                'type' => 'Online Access',
                'category' => 'courses',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=300&fit=crop',
                'link' => 'https://ocw.mit.edu/',
                'rating' => 4.9,
                'user_count' => '5M+',
                'featured' => true,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Google Scholar',
                'description' => 'Search scholarly literature across many disciplines and sources',
                'type' => 'Online Access',
                'category' => 'research',
                'image_url' => 'https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=400&h=300&fit=crop',
                'link' => 'https://scholar.google.com/',
                'rating' => 4.7,
                'user_count' => '10M+',
                'featured' => false,
                'status' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'JSTOR',
                'description' => 'Digital library of academic journals, books, and primary sources',
                'type' => 'Online Access',
                'category' => 'journals',
                'image_url' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop',
                'link' => 'https://www.jstor.org/',
                'rating' => 4.6,
                'user_count' => '3M+',
                'featured' => false,
                'status' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Open Library',
                'description' => 'Open, editable library catalog with over 3 million books',
                'type' => 'Downloadable',
                'category' => 'ebooks',
                'image_url' => 'https://images.unsplash.com/photo-1568667256549-094345857637?w=400&h=300&fit=crop',
                'link' => 'https://openlibrary.org/',
                'rating' => 4.5,
                'user_count' => '1M+',
                'featured' => false,
                'status' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'PubMed',
                'description' => 'Biomedical literature database with life sciences journals',
                'type' => 'Online Access',
                'category' => 'research',
                'image_url' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop',
                'link' => 'https://pubmed.ncbi.nlm.nih.gov/',
                'rating' => 4.8,
                'user_count' => '4M+',
                'featured' => true,
                'status' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Khan Academy',
                'description' => 'Free online courses, lessons, and practice across many subjects',
                'type' => 'Online Access',
                'category' => 'courses',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=300&fit=crop',
                'link' => 'https://www.khanacademy.org/',
                'rating' => 4.7,
                'user_count' => '8M+',
                'featured' => false,
                'status' => true,
                'sort_order' => 7,
            ],
            [
                'title' => 'arXiv',
                'description' => 'Open access to e-prints in Physics, Mathematics, Computer Science, and more',
                'type' => 'Online Access',
                'category' => 'research',
                'image_url' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=400&h=300&fit=crop',
                'link' => 'https://arxiv.org/',
                'rating' => 4.6,
                'user_count' => '2M+',
                'featured' => false,
                'status' => true,
                'sort_order' => 8,
            ],
            [
                'title' => 'Internet Archive',
                'description' => 'Digital library with millions of free books, movies, software, music, and more',
                'type' => 'Downloadable',
                'category' => 'multimedia',
                'image_url' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop',
                'link' => 'https://archive.org/',
                'rating' => 4.7,
                'user_count' => '6M+',
                'featured' => true,
                'status' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($resources as $resource) {
            LibraryResource::create($resource);
        }

        $this->command->info('Library resources seeded successfully!');
    }
}
