@extends('admin.layouts.app')

@push('title', 'Create Product')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Product</h5>
                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Products</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Store & Brand -->
                            <div class="col-md-6 mb-3">
                                <label for="store_id" class="form-label">Store <span class="text-danger">*</span></label>
                                <select name="store_id" id="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                                    <option value="">Select Store</option>
                                    @foreach($stores as $store)
                                    <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->store_name ?? $store->name ?? 'Store '.$store->id }}</option>
                                    @endforeach
                                </select>
                                @error('store_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                                <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Categories -->
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sub_category" class="form-label">Sub Category</label>
                                <select name="sub_category" id="sub_category" class="form-select @error('sub_category') is-invalid @enderror">
                                    <option value="">Select Sub Category</option>
                                    <!-- Options will be populated via AJAX -->
                                </select>
                                @error('sub_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <select name="tags[]" id="tags" class="form-select @error('tags') is-invalid @enderror" multiple>
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ (old('tags') && in_array($tag->id, old('tags'))) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hold CTRL (Windows) or CMD (Mac) to select multiple tags.</small>
                            </div>

                            <!-- Pricing -->
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3 d-flex align-items-center">
                                <div class="form-check mt-3">
                                    <input type="checkbox" name="has_discount" id="has_discount" class="form-check-input" value="1" {{ old('has_discount') ? 'checked' : '' }}>
                                    <label for="has_discount" class="form-check-label text-danger fw-bold">Apply Discount?</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 text-end d-flex justify-content-end align-items-center">
                                <h4 class="mb-0">Final Price: <span id="final_price_preview" class="text-success">$0.00</span></h4>
                            </div>

                            <!-- Discount Fields (Hidden by default) -->
                            <div class="col-12 discount-section" style="display: none;">
                                <div class="card bg-light mb-3">
                                    <div class="card-body row">
                                        <div class="col-md-3 mb-3">
                                            <label for="discount_type" class="form-label">Discount Type</label>
                                            <select name="discount_type" id="discount_type" class="form-select">
                                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="discount_value" class="form-label">Discount Value</label>
                                            <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control" value="{{ old('discount_value', 0) }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="discount_start_date" class="form-label">Start Date</label>
                                            <input type="date" name="discount_start_date" id="discount_start_date" class="form-control" value="{{ old('discount_start_date') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="discount_end_date" class="form-label">End Date</label>
                                            <input type="date" name="discount_end_date" id="discount_end_date" class="form-control" value="{{ old('discount_end_date') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory -->
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Stock Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}">
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                                @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Images -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Main Product Image <span class="text-muted">(Thumbnail)</span></label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gallery_images" class="form-label">Additional Images <span class="text-muted">(Multiple allowed)</span></label>
                                <input type="file" name="gallery_images[]" id="gallery_images" class="form-control @error('gallery_images.*') is-invalid @enderror" accept="image/*" multiple>
                                @error('gallery_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Main Image Preview</label>
                                <div class="mb-2 p-2 border rounded" id="main_image_preview" style="min-height: 100px; display:flex; align-items:center; justify-content:center; background:#f8f9fa;">
                                    <span class="text-muted">Select an image to view preview</span>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Gallery Preview</label>
                                <div class="d-flex flex-wrap gap-2 p-2 border rounded" id="gallery_preview" style="min-height: 100px; background:#f8f9fa;">
                                    <span class="text-muted w-100 text-center my-auto">Select additional images to view preview</span>
                                </div>
                            </div>

                            <!-- Descriptions -->
                            <div class="col-md-12 mb-3">
                                <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea name="short_description" id="short_description" rows="2" class="form-control @error('short_description') is-invalid @enderror" required>{{ old('short_description') }}</textarea>
                                @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Toggles -->
                            <div class="col-md-3 mb-3 form-check ms-3">
                                <input type="checkbox" name="is_feature" id="is_feature" class="form-check-input" value="1" {{ old('is_feature') ? 'checked' : '' }}>
                                <label for="is_feature" class="form-check-label">Featured Product</label>
                            </div>

                            <div class="col-md-3 mb-3 form-check ms-3">
                                <input type="checkbox" name="is_hot" id="is_hot" class="form-check-input" value="1" {{ old('is_hot') ? 'checked' : '' }}>
                                <label for="is_hot" class="form-check-label">Hot Product</label>
                            </div>

                            <div class="col-md-3 mb-3 form-check ms-3">
                                <input type="checkbox" name="is_new" id="is_new" class="form-check-input" value="1" {{ old('is_new') ? 'checked' : '' }}>
                                <label for="is_new" class="form-check-label">New Product</label>
                            </div>

                            <div class="col-md-12 mb-3 mt-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select w-25 @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-4 border-top pt-3 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Target Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Dynamic Subcategory Loading
        const categorySelect = document.getElementById('category');
        const subCategorySelect = document.getElementById('sub_category');

        categorySelect.addEventListener('change', function() {
            let categoryId = this.value;
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            if (categoryId) {
                let url = `{{ url('admin/product/get-subcategories') }}/${categoryId}`;
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(sub => {
                            let option = `<option value="${sub.id}">${sub.name}</option>`;
                            subCategorySelect.insertAdjacentHTML('beforeend', option);
                        });
                    })
                    .catch(error => console.error('Error loading subcategories:', error));
            }
        });

        // 2. Discount Calculation and Toggle
        const priceInput = document.getElementById('price');
        const hasDiscountCheckbox = document.getElementById('has_discount');
        const discountSection = document.querySelector('.discount-section');
        const discountType = document.getElementById('discount_type');
        const discountValue = document.getElementById('discount_value');
        const finalPricePreview = document.getElementById('final_price_preview');

        function calculateFinalPrice() {
            let price = parseFloat(priceInput.value) || 0;
            let finalPrice = price;

            if (hasDiscountCheckbox.checked) {
                let dType = discountType.value;
                let dValue = parseFloat(discountValue.value) || 0;

                if (dType === 'percentage') {
                    finalPrice = price - (price * (dValue / 100));
                } else if (dType === 'fixed') {
                    finalPrice = price - dValue;
                }
            }
            if (finalPrice < 0) finalPrice = 0;
            finalPricePreview.textContent = '$' + finalPrice.toFixed(2);
        }

        function toggleDiscountSection() {
            if (hasDiscountCheckbox.checked) {
                discountSection.style.display = 'block';
            } else {
                discountSection.style.display = 'none';
            }
            calculateFinalPrice();
        }

        hasDiscountCheckbox.addEventListener('change', toggleDiscountSection);
        priceInput.addEventListener('input', calculateFinalPrice);
        discountType.addEventListener('change', calculateFinalPrice);
        discountValue.addEventListener('input', calculateFinalPrice);

        // Initialization check
        toggleDiscountSection();

        // 3. Image Previews
        const imageInput = document.getElementById('image');
        const mainImagePreview = document.getElementById('main_image_preview');

        imageInput.addEventListener('change', function(e) {
            mainImagePreview.innerHTML = '';
            if (this.files && this.files[0]) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[0]);
                img.style.maxHeight = '150px';
                img.style.borderRadius = '5px';
                mainImagePreview.appendChild(img);
            } else {
                mainImagePreview.innerHTML = '<span class="text-muted">Select an image to view preview</span>';
            }
        });

        // Gallery Preview
        const galleryInput = document.getElementById('gallery_images');
        const galleryPreview = document.getElementById('gallery_preview');

        galleryInput.addEventListener('change', function(e) {
            galleryPreview.innerHTML = '';
            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach(file => {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxHeight = '100px';
                    img.style.maxWidth = '100px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '5px';
                    img.classList.add('shadow-sm');
                    galleryPreview.appendChild(img);
                });
            } else {
                galleryPreview.innerHTML = '<span class="text-muted w-100 text-center my-auto">Select additional images to view preview</span>';
            }
        });
    });
</script>
@endpush
@endsection