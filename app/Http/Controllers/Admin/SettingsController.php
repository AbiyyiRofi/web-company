<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::singleton();
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::singleton();

        $data = $request->validate(['logo' => 'required|image']);

        if ($setting->logo) {
            Storage::disk('public')->delete($setting->logo);
        }
        $data['logo'] = $request->file('logo')->store('settings', 'public');

        $setting->update($data);

        return back()->with('success', 'Logo berhasil diperbarui.');
    }
}
