<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function storeIndex()
    {
        $store = Store::where('seller_id', auth()->user()->id)->first();

        return view('vendor_user.store.index', compact('store'));
    }

    public function storeStore(Request $request)
    {
        $request->validate([
            'store_name' => 'required',
            'store_phone' => 'nullable',
            'store_email' => 'nullable|email',
            'short_description' => 'nullable',
            'long_description' => 'nullable',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',
        ]);

        $store = Store::where('seller_id', auth()->user()->id)->first();

        // Defaults or keeping old files
        $logoPath = $store ? $store->logo : 'default/logo-placeholder.png';
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store_images', 'public');
        }

        $bannerPath = $store ? $store->banner : 'default/banner-placeholder.png';
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('store_images', 'public');
        }

        // update store or create store
        Store::updateOrCreate(
            [
                'seller_id' => auth()->user()->id,
            ],
            [
                'store_name' => $request->store_name,
                'logo' => $logoPath,
                'banner' => $bannerPath,
                'store_phone' => $request->store_phone,
                'store_email' => $request->store_email,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]
        );

        return redirect()->route('vendor.store.index')->with('success', 'Store configuration completed successfully!');
    }
}
