<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionGrupo extends Model
{
    protected $table = 'accion_grupo';

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'accion_id',
        'grupo_id',
        'user_created_id', 
        'user_updated_id'
    ];

    public function accion() {
        return $this->belongsTo(Accion::class);
    }

    public function grupo() {
        return $this->belongsTo(Grupo::class);
    }
}
