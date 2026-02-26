<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();
        $stores = \App\Models\Store::all();
        $categories = Category::all();
        $subCategories = collect(); // will be loaded via ajax, or we can leave empty
        $tags = Tag::all();

        return view('admin.product.create', compact('brands', 'stores', 'categories', 'subCategories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'price' => 'required|numeric',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                $fileName = time() . '_' . $index . '.' . $file->extension();
                $file->move(public_path('uploads/products/gallery'), $fileName);
                $galleryPaths[] = 'uploads/products/gallery/' . $fileName;
            }
        }

        // Calculate discount
        $discountPrice = null;
        if ($request->has_discount == '1') {
            if ($request->discount_type == 'percentage') {
                $discountPrice = $request->price - ($request->price * ($request->discount_value / 100));
            } elseif ($request->discount_type == 'fixed') {
                $discountPrice = $request->price - $request->discount_value;
            }
            if ($discountPrice < 0) $discountPrice = 0;
        }

        Product::create([
            'store_id' => $request->store_id,
            'brand_id' => $request->brand_id,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'type' => $request->type ?? 'physical',
            'price' => $request->price,
            'discount_price' => $discountPrice,
            'discount_type' => $request->has_discount == '1' ? $request->discount_type : null,
            'discount_value' => $request->has_discount == '1' ? $request->discount_value : null,
            'discount_start_date' => $request->has_discount == '1' ? $request->discount_start_date : null,
            'discount_end_date' => $request->has_discount == '1' ? $request->discount_end_date : null,
            'quantity' => $request->quantity ?? 0,
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imagePath,
            'gallery_images' => $galleryPaths,
            'tags' => $request->tags ? json_encode($request->tags) : null,
            'status' => $request->status ?? 'active',
            'is_feature' => $request->has('is_feature'),
            'is_hot' => $request->has('is_hot'),
            'is_new' => $request->has('is_new'),
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $stores = \App\Models\Store::all();
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $product->category)->get();
        $tags = Tag::all();

        return view('admin.product.edit', compact('product', 'brands', 'stores', 'categories', 'subCategories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'price' => 'required|numeric',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        $galleryPaths = $product->gallery_images ?? [];
        if ($request->hasFile('gallery_images')) {
            // Optional: delete old gallery images or append. Let's replace for simplicity
            if (is_array($product->gallery_images)) {
                foreach ($product->gallery_images as $oldImage) {
                    if (File::exists(public_path($oldImage))) {
                        File::delete(public_path($oldImage));
                    }
                }
            }
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $index => $file) {
                $fileName = time() . '_' . $index . '.' . $file->extension();
                $file->move(public_path('uploads/products/gallery'), $fileName);
                $galleryPaths[] = 'uploads/products/gallery/' . $fileName;
            }
        }

        // Calculate discount
        $discountPrice = null;
        if ($request->has_discount == '1') {
            if ($request->discount_type == 'percentage') {
                $discountPrice = $request->price - ($request->price * ($request->discount_value / 100));
            } elseif ($request->discount_type == 'fixed') {
                $discountPrice = $request->price - $request->discount_value;
            }
            if ($discountPrice < 0) $discountPrice = 0;
        }

        $product->update([
            'store_id' => $request->store_id,
            'brand_id' => $request->brand_id,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'type' => $request->type ?? 'physical',
            'price' => $request->price,
            'discount_price' => $discountPrice,
            'discount_type' => $request->has_discount == '1' ? $request->discount_type : null,
            'discount_value' => $request->has_discount == '1' ? $request->discount_value : null,
            'discount_start_date' => $request->has_discount == '1' ? $request->discount_start_date : null,
            'discount_end_date' => $request->has_discount == '1' ? $request->discount_end_date : null,
            'quantity' => $request->quantity ?? 0,
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imagePath,
            'gallery_images' => $galleryPaths,
            'tags' => $request->tags ? json_encode($request->tags) : null,
            'status' => $request->status ?? 'active',
            'is_feature' => $request->has('is_feature'),
            'is_hot' => $request->has('is_hot'),
            'is_new' => $request->has('is_new'),
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        if (is_array($product->gallery_images)) {
            foreach ($product->gallery_images as $oldImage) {
                if (File::exists(public_path($oldImage))) {
                    File::delete(public_path($oldImage));
                }
            }
        }
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }

    public function getSubcategories($category_id)
    {
        $subCategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subCategories);
    }
}
