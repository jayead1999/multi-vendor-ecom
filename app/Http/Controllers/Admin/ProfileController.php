<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\FileUploadTraits;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTraits;
    public function index()
    {
        return view('admin/profile/index');
    }

    // Update profile information
    public function updateProfile(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();

        $filePath = $user->profile_picture; // keep old image by default

        if ($request->hasFile('profile_picture')) {
            \Log::info('Profile picture found in request.');
            $filePath = $this->fileUpload($request->file('profile_picture'), $user->profile_picture);
            \Log::info('File upload result: ' . $filePath);
        } else {
            \Log::info('No profile picture in request.');
        }

        $user->update([
            'name'            => $request->name,
            'email'           => $request->email,
            'profile_picture' => $filePath,
        ]);

        return back()->with('status', 'Update successful');
        // return "Reached Controller";

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('status', 'Password updated successfully');
    }
   
}
