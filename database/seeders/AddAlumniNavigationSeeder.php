<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationMenu;
use App\Models\NavigationItem;

class AddAlumniNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the header navigation menu
        $menu = NavigationMenu::where('location', 'header')->first();

        if ($menu) {
            // Check if Alumni item already exists
            $existingItem = NavigationItem::where('menu_id', $menu->id)
                ->where('label', 'Alumni')
                ->first();

            if (!$existingItem) {
                // Get the current max order
                $maxOrder = NavigationItem::where('menu_id', $menu->id)->max('order');
                
                // Create Alumni navigation item
                NavigationItem::create([
                    'menu_id' => $menu->id,
                    'label' => 'Alumni',
                    'url' => '/alumni',
                    'order' => $maxOrder + 1,
                    'is_active' => true
                ]);
                
                $this->command->info('Alumni navigation item added successfully.');
            } else {
                $this->command->info('Alumni navigation item already exists.');
            }
        } else {
            $this->command->error('Header navigation menu not found.');
        }
    }
}
