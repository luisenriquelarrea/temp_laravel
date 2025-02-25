<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeccionMenu extends Model
{
    protected $table = 'seccion_menu';

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'menu_id',
        'descripcion',
        'navbar_label',
        'icon',
        'user_created_id', 
        'user_updated_id'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
