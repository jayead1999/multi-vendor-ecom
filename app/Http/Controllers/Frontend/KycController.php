<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller implements HasMiddleware

{

    static function middleware(): array
    {
        return [
            new Middleware('permission:kyc')
        ] ;  
    }

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


    // admin kyc request
    public function kycRequest(Request $request)
    {
        $query = Kyc::query();

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $kycRequests = $query->latest()->paginate(15);
        return view('admin.kyc.index', compact('kycRequests'));
    }

    // admin kyc pending request
    public function kycPendingRequest(Request $request)
    {
        $query = Kyc::query()->where('status', 'pending');

        $kycRequests = $query->latest()->paginate(15);
        return view('admin.kyc.pending', compact('kycRequests'));
    }

    // admin kyc request approve
    public function kycRequestApprove($id)
    {
        $kycRequest = Kyc::find($id);
        $kycRequest->status = 'approved';
        $kycRequest->verified_at = now();
        $kycRequest->save();
        return redirect()->route('admin.kyc.request')->with('success', 'KYC request approved successfully');
    }

    // admin kyc request reject
    public function kycRequestReject(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'required|string|max:1000'
        ]);

        $kycRequest = Kyc::find($id);
        $kycRequest->status = 'rejected';
        $kycRequest->rejected_reason = $request->rejected_reason;
        $kycRequest->save();
        return redirect()->route('admin.kyc.request')->with('success', 'KYC request rejected successfully');
    }

    // admin kyc request show
    public function kycRequestShow($id)
    {
        $kycRequest = Kyc::findOrFail($id);
        return view('admin.kyc.show', compact('kycRequest'));
    }

    // admin kyc request delete
    public function kycRequestDelete($id)
    {
        $kycRequest = Kyc::findOrFail($id);
        $kycRequest->delete();
        return redirect()->route('admin.kyc.request')->with('success', 'KYC request deleted successfully');
    }
}
