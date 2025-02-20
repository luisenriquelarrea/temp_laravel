<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    protected $table = 'accion';

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'seccion_menu_id',
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

    public function seccionMenu()
    {
        return $this->belongsTo(SeccionMenu::class);
    }
}
