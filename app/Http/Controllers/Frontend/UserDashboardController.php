<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserDashboardController extends Controller
{
    use \App\Traits\FileUploadTraits;
    public function index()
    {

        // $user = User::get();
        $user = auth()->user();
        // return response()->json($user);
        return view('frontend.dashboard.pages.index', compact('user'));
    }

    public function orders()
    {
        return view('frontend.dashboard.pages.orders');
    }

    public function trackOrders()
    {
        return view('frontend.dashboard.pages.trackOrder');
    }

    public function address()
    {
        return view('frontend.dashboard.pages.address');
    }

    public function account()
    {
        $user = auth()->user();
        return view('frontend.dashboard.pages.account', compact('user'));
    }

    public function wishlist()
    {
        return view('frontend.dashboard.pages.wishlist');
    }

    public function editAccount(Request $request)
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

    // Post Update Password
    public function updatePassword(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
