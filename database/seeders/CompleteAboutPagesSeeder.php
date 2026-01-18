<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompleteAboutPagesSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        $whoWeAreContent = <<<'HTML'
<div class="vc-message">
<h2>MESSAGE FROM THE DESK OF THE VICE CHANCELLOR</h2>
<p>Welcome to University of Africa. As we embark on this exciting chapter in our institution's growth, I am delighted to invite you to join a community dedicated to transformative learning and meaningful impact across Africa and beyond.</p>
<p>The University of Africa stands at a critical moment in African higher education. We are committed to developing the next generation of scholars, leaders, and practitioners who will address the continent's most pressing challenges through evidence-based professional practice, research, and ethical leadership.</p>
<p>Whether you are building on a successful career or launching a new direction, our programmes are designed to support your intellectual development while respecting the realities of your professional and personal commitments.</p>
<p>I encourage you to view this prospectus not simply as a guide to programmes and facilities, but as an invitation to become part of an institution that takes seriously both academic excellence and the social responsibility that comes with it.</p>
<p><strong>Together, we can contribute to shaping Africa's future.</strong></p>
<p><strong>Dr Ephraim Kaang'andu Belemu</strong><br><em>Vice Chancellor, University of Africa</em></p>
</div>

<h2>About the University of Africa</h2>
<p>The <strong>University of Africa (UA)</strong>, established in 2008, is a leading institution committed to serving Zambia and the African continent with excellence and integrity. Guided by our mission to provide high-quality, affordable, and flexible education, we aim to empower our students to achieve personal growth, financial independence, and global success.</p>

<div class="vision-motto">
<h3>Vision & Motto</h3>
<p><strong>Mission:</strong> Flexible learning opportunities using modern technology, world-class materials, and personal guidance.</p>
<p><strong>Motto:</strong> <em>Grow, Prosper, Excel</em></p>
</div>

<h3>Why Choose Us?</h3>
<ul>
<li>Fast-track diploma upgrades to bachelor's degrees within 2 years</li>
<li>Continuous registration throughout the year</li>
<li>Affordable education with scholarships for determined students</li>
<li>Flexible payment systems and modular study materials</li>
<li>Accredited to offer qualifications from diplomas to doctorate levels</li>
</ul>

<h3>Our Commitment</h3>
<p>UA fosters a blend of distance learning and Zambian qualifications that meet the demands of the African workforce. We ensure our students excel in their careers, businesses, and personal lives through accessible education that drives growth, prosperity, and excellence.</p>

<h3>Affiliations</h3>
<p>UA collaborates with renowned institutions across Southern Africa, including CIRSM Zimbabwe, RIME Zimbabwe, Workers University College (Eswatini), Empirical Academy (South Africa), and SAIHER.</p>

<div class="logo-symbolism">
<h3>Logo Symbolism</h3>
<p>UA is a child of Africa. We are proud of our continent and its people. Therefore, the African continent is the focal point of the logo, and henceforth, UA will not be limited as a Zambian University only, but instead be a continental university, with a broad roll-out of its learning programmes.</p>
<p>Secondly, we support simplicity. Therefore, this logo is a design with simplicity at its heart, and the university will be known for the simple yet effective way it provides services.</p>
<p>Thirdly this logo stands out for several reasons. The colour is unique and catches the eye. The bold expression of our name says who we are. The modernness of this logo reflects our modern approach towards digital learning.</p>
</div>

<h3>Join UA Today</h3>
<p>We are more than a university; we are your partner in achieving excellence and transforming lives. Together, we will build a brighter future for Africa and beyond.</p>
HTML;

        $pages = [
            [
                'title' => 'Who We Are',
                'slug' => 'who-we-are',
                'content' => $whoWeAreContent,
                'meta_title' => 'Who We Are - University of Africa',
                'meta_description' => 'Learn about University of Africa, our mission, vision, and commitment to excellence in education',
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

        $this->command->info('Complete About pages seeded successfully!');
    }
}
