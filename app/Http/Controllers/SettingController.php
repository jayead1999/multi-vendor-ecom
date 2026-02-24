<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\SettingService;
use App\Traits\FileUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    use FileUploadTraits;

    public function index()
    {
        return view('admin.settings.index');
    }
    public function generalSetting()
    {
        return view('admin.settings.generalIndex');
    }

    public function updateGeneralSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'site_phone_number' => 'nullable|string|max:255',
        ]);

        foreach ($request->only(['site_name', 'site_email', 'site_phone_number']) as $key => $value) {
            Setting::set($key, $value);
        }
        $settings = app()->make(SettingService::class);
        $settings->clearCashedSettings();


        return back()->with('status', 'General settings updated successfully.');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,' . auth('admin')->id(),
            'email' => 'required|email|max:255|unique:admins,email,' . auth('admin')->id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth('admin')->user();

        $filePath = $user->profile_picture;
        if ($request->hasFile('profile_picture')) {
            $filePath = $this->fileUpload($request->file('profile_picture'), $user->profile_picture);
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'profile_picture' => $filePath,
        ]);

        return back()->with('status', 'Settings updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password:admin',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth('admin')->user();

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('status', 'Password updated successfully.');
    }
}
