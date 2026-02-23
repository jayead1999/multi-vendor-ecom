<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'rejected_reason',
        'verified_at',
        'full_name',
        'date_of_birth',
        'gender',
        'full_address',
        'document_type',
        'document_scan_copy',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
