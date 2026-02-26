<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'brand_id',
        'category',
        'sub_category',
        'name',
        'slug',
        'type',
        'image',
        'gallery_images',
        'sku',
        'quantity',
        'price',
        'discount_price',
        'discount_type',
        'discount_value',
        'discount_start_date',
        'discount_end_date',
        'description',
        'short_description',
        'tags',
        'manage_stock',
        'view_count',
        'is_feature',
        'is_hot',
        'is_new',
        'status',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'tags' => 'array',
        'discount_start_date' => 'date',
        'discount_end_date' => 'date',
        'is_feature' => 'boolean',
        'is_hot' => 'boolean',
        'is_new' => 'boolean',
    ];
}
