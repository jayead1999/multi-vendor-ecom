<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class KycController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:kyc'),
        ];
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
            'rejected_reason' => 'required|string|max:1000',
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
