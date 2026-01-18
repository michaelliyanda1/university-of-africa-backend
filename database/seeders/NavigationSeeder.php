<?php

namespace Database\Seeders;

use App\Models\NavigationMenu;
use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        $headerMenu = NavigationMenu::updateOrCreate(
            ['slug' => 'main-header'],
            [
                'name' => 'Main Header Menu',
                'location' => 'header',
                'is_active' => true,
            ]
        );

        $menuItems = [
            [
                'label' => 'Home',
                'url' => '/',
                'route' => '/',
                'order' => 1,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'label' => 'Programmes',
                'url' => '/programmes',
                'route' => '/programmes',
                'order' => 2,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'label' => 'News',
                'url' => '/news',
                'route' => '/news',
                'order' => 3,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'label' => 'Research',
                'url' => '/research',
                'route' => '/research',
                'order' => 4,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'label' => 'Departments',
                'url' => '/departments',
                'route' => '/departments',
                'order' => 5,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'label' => 'About',
                'url' => '#',
                'route' => null,
                'order' => 6,
                'is_active' => true,
                'parent_id' => null,
            ],
        ];

        foreach ($menuItems as $itemData) {
            $item = NavigationItem::updateOrCreate(
                [
                    'menu_id' => $headerMenu->id,
                    'label' => $itemData['label'],
                    'parent_id' => null,
                ],
                array_merge($itemData, ['menu_id' => $headerMenu->id])
            );

            if ($itemData['label'] === 'About') {
                $aboutSubItems = [
                    [
                        'label' => 'Who We Are',
                        'url' => '/about/who-we-are',
                        'route' => '/about/who-we-are',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'label' => 'Vision & Mission',
                        'url' => '/about/vision-mission',
                        'route' => '/about/vision-mission',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'label' => 'Leadership',
                        'url' => '/about/leadership',
                        'route' => '/about/leadership',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'label' => 'Our History',
                        'url' => '/about/history',
                        'route' => '/about/history',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($aboutSubItems as $subItemData) {
                    NavigationItem::updateOrCreate(
                        [
                            'menu_id' => $headerMenu->id,
                            'parent_id' => $item->id,
                            'label' => $subItemData['label'],
                        ],
                        array_merge($subItemData, [
                            'menu_id' => $headerMenu->id,
                            'parent_id' => $item->id,
                        ])
                    );
                }
            }
        }

        $topBarMenu = NavigationMenu::updateOrCreate(
            ['slug' => 'top-bar'],
            [
                'name' => 'Top Bar Menu',
                'location' => 'header',
                'is_active' => true,
            ]
        );

        $topBarItems = [
            [
                'label' => 'Alumni',
                'url' => '#',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Student Portal',
                'url' => '#',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($topBarItems as $itemData) {
            $item = NavigationItem::updateOrCreate(
                [
                    'menu_id' => $topBarMenu->id,
                    'label' => $itemData['label'],
                    'parent_id' => null,
                ],
                array_merge($itemData, ['menu_id' => $topBarMenu->id])
            );

            if ($itemData['label'] === 'Student Portal') {
                $portalSubItems = [
                    [
                        'label' => 'Library Services',
                        'url' => '/library-services',
                        'route' => '/library-services',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'label' => 'Student Portal',
                        'url' => 'https://keystoneportal.net/main.html',
                        'target' => '_blank',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'label' => 'Forms & Downloads',
                        'url' => '/forms-downloads',
                        'route' => '/forms-downloads',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'label' => 'Academic Calendar',
                        'url' => '/academic-calendar',
                        'route' => '/academic-calendar',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ];

                foreach ($portalSubItems as $subItemData) {
                    NavigationItem::updateOrCreate(
                        [
                            'menu_id' => $topBarMenu->id,
                            'parent_id' => $item->id,
                            'label' => $subItemData['label'],
                        ],
                        array_merge($subItemData, [
                            'menu_id' => $topBarMenu->id,
                            'parent_id' => $item->id,
                        ])
                    );
                }
            }
        }

        $this->command->info('Navigation menus seeded successfully!');
    }
}
