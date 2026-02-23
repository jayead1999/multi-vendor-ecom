<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'seller_id',
        'logo',
        'banner',
        'store_name',
        'store_phone',
        'store_email',
        'short_description',
        'long_description',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
