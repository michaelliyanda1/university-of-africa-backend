<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NavigationController extends Controller
{
    public function getPublicMenu($location)
    {
        $menu = NavigationMenu::where('location', $location)
            ->where('is_active', true)
            ->with(['rootItems' => function($query) {
                $query->where('is_active', true)
                    ->orderBy('order')
                    ->with(['children' => function($q) {
                        $q->where('is_active', true)->orderBy('order');
                    }]);
            }])
            ->first();

        if (!$menu) {
            return response()->json(['items' => []])
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return response()->json([
            'menu' => $menu,
            'items' => $menu->rootItems
        ])
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }
    public function indexMenus()
    {
        $menus = NavigationMenu::with('items')->get();
        return response()->json($menus);
    }

    public function showMenu(NavigationMenu $menu)
    {
        return response()->json($menu->load('rootItems.children'));
    }

    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:header,footer,sidebar',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $menu = NavigationMenu::create($validated);

        return response()->json([
            'message' => 'Navigation menu created successfully',
            'menu' => $menu
        ], 201);
    }

    public function updateMenu(Request $request, NavigationMenu $menu)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|in:header,footer,sidebar',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $menu->update($validated);

        return response()->json([
            'message' => 'Navigation menu updated successfully',
            'menu' => $menu
        ]);
    }

    public function destroyMenu(NavigationMenu $menu)
    {
        $menu->delete();

        return response()->json([
            'message' => 'Navigation menu deleted successfully'
        ]);
    }

    public function indexItems(NavigationMenu $menu)
    {
        $items = $menu->rootItems()->with('children')->get();
        return response()->json($items);
    }

    public function storeItem(Request $request, NavigationMenu $menu)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:navigation_items,id',
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'target' => 'sometimes|string|in:_self,_blank',
            'order' => 'sometimes|integer',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
        ]);

        $validated['menu_id'] = $menu->id;

        $item = NavigationItem::create($validated);

        return response()->json([
            'message' => 'Navigation item created successfully',
            'item' => $item->load('children')
        ], 201);
    }

    public function updateItem(Request $request, NavigationItem $item)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:navigation_items,id',
            'label' => 'sometimes|required|string|max:255',
            'url' => 'nullable|string|max:500',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'target' => 'sometimes|string|in:_self,_blank',
            'order' => 'sometimes|integer',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
        ]);

        $item->update($validated);

        return response()->json([
            'message' => 'Navigation item updated successfully',
            'item' => $item->load('children')
        ]);
    }

    public function destroyItem(NavigationItem $item)
    {
        $item->delete();

        return response()->json([
            'message' => 'Navigation item deleted successfully'
        ]);
    }

    public function reorderItems(Request $request, NavigationMenu $menu)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:navigation_items,id',
            'items.*.order' => 'required|integer',
            'items.*.parent_id' => 'nullable|exists:navigation_items,id',
        ]);

        foreach ($validated['items'] as $itemData) {
            NavigationItem::where('id', $itemData['id'])->update([
                'order' => $itemData['order'],
                'parent_id' => $itemData['parent_id'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Navigation items reordered successfully'
        ]);
    }
}
