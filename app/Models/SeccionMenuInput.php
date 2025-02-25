<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeccionMenuInput extends Model
{
    protected $table = 'seccion_menu_input';

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'seccion_menu_id',
        'input_type',
        'input_label',
        'input_id',
        'input_name',
        'input_cols',
        'input_required',
        'input_accepts',
        'alta',
        'modifica',
        'lista',
        'filtro',
        'encabezado',
        'new_line',
        'currency_format',
        'orden',
        'select_columnas',
        'url_get',
        'modelo',
        'user_created_id', 
        'user_updated_id'
    ];

    public function seccionMenu()
    {
        return $this->belongsTo(SeccionMenu::class);
    }
}