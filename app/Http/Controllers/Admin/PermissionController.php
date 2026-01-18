<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $permission = Permission::create($validated);

        return response()->json([
            'message' => 'Permission created successfully',
            'permission' => $permission
        ], 201);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $permission->update($validated);

        return response()->json([
            'message' => 'Permission updated successfully',
            'permission' => $permission
        ]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
