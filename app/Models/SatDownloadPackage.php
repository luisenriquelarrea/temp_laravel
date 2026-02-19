<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatDownloadPackage extends Model
{
    protected $fillable = [
        'sat_download_request_id',
        'package_id',
        'status',
        'error_message'
    ];

    public function request()
    {
        return $this->belongsTo(SatDownloadRequest::class);
    }
}
