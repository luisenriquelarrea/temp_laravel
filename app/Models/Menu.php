<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'descripcion',
        'label',
        'icon',
        'orden',
        'user_created_id', 
        'user_updated_id'
    ];
}
