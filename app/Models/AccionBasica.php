<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionBasica extends Model
{
    protected $table = 'accion_basica';

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'descripcion', 
        'call_method', 
        'label', 
        'icon', 
        'on_breadcrumb', 
        'on_navbar', 
        'on_table', 
        'user_created_id', 
        'user_updated_id'
    ];
}
