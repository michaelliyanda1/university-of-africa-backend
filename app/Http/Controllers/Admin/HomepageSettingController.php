<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class HomepageSettingController extends Controller
{
    public function index()
    {
        $settings = HomepageSetting::all();
        return response()->json($settings);
    }

    public function update(Request $request, $id)
    {
        $setting = HomepageSetting::findOrFail($id);
        
        $validated = $request->validate([
            'value' => 'required|string',
        ]);

        $setting->update($validated);

        return response()->json([
            'message' => 'Setting updated successfully',
            'setting' => $setting
        ]);
    }

    public function updateBulk(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.id' => 'required|exists:homepage_settings,id',
            'settings.*.value' => 'required|string',
        ]);

        foreach ($validated['settings'] as $settingData) {
            HomepageSetting::where('id', $settingData['id'])->update([
                'value' => $settingData['value'],
            ]);
        }

        return response()->json([
            'message' => 'Settings updated successfully'
        ]);
    }
}
