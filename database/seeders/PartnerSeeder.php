<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'Africa Research University', 'logo_path' => '/partners/africa research.png', 'category' => 'academic', 'is_active' => true, 'order' => 1],
            ['name' => 'Redeemer\'s College', 'logo_path' => '/partners/rectem.png', 'category' => 'academic', 'is_active' => true, 'order' => 2],
            ['name' => 'CIRSM', 'logo_path' => '/partners/cirsm.png', 'category' => 'academic', 'is_active' => true, 'order' => 3],
            ['name' => 'Empirical University', 'logo_path' => '/partners/empiri.png', 'category' => 'academic', 'is_active' => true, 'order' => 4],
            ['name' => 'Higher Education Authority', 'logo_path' => '/partners/HEA.png', 'category' => 'government', 'is_active' => true, 'order' => 5],
            ['name' => 'Zambia Qualifications Authority', 'logo_path' => '/partners/zaqa-logo.png', 'category' => 'government', 'is_active' => true, 'order' => 6],
        ];

        foreach ($partners as $partner) {
            DB::table('partners')->insert(array_merge($partner, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
