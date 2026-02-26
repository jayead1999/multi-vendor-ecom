<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.home.index');
    }

    // Vendor Kyc 
     public function kycIndex()
    {
        return view('frontend.pages.kyc');
    }

    public function kycStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required|in:male,female,other',
            'full_address' => 'required',
            'document_type' => 'required|in:passport,driving_license,national_id,other',
            'document_scan_copy' => 'required|image|max:2048',
        ]);
        if (Kyc::where('user_id', Auth::id())->whereIn('status', ['pending', 'approved'])->exists()) {
            return redirect()->route('vendor.dashboard')->with('error', 'KYC already submitted or approved.');
        }

        $imagePath = null;
        if ($request->hasFile('document_scan_copy')) {
            $imagePath = $request->file('document_scan_copy')->store('kyc_documents', 'public');
        }

        $kyc = new Kyc();
        $kyc->user_id = Auth::id();
        $kyc->full_name = $request->full_name;
        $kyc->date_of_birth = $request->date_of_birth;
        $kyc->gender = $request->gender;
        $kyc->full_address = $request->full_address;
        $kyc->document_type = $request->document_type;
        $kyc->document_scan_copy = $imagePath;
        $kyc->save();

        return redirect()->route('vendor.dashboard')->with('success', 'KYC submitted successfully');
    }
}
