<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json(
            Department::where('is_active', true)
                ->orderBy('order')
                ->withCount('communities')
                ->get()
        );
    }

    public function show(Department $department)
    {
        return response()->json(
            $department->load(['communities.collections'])
        );
    }
}
