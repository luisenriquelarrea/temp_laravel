<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatDownloadRequest extends Model
{
    protected $fillable = [
        'request_id',
        'date_from',
        'date_to',
        'status',
        'packages_count',
        'last_verified_at',
    ];

    protected $casts = [
        'date_from' => 'datetime',
        'date_to' => 'datetime',
        'last_verified_at' => 'datetime',
    ];

    public function packages()
    {
        return $this->hasMany(SatDownloadPackage::class);
    }
}
