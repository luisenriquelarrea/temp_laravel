<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plaza extends Model
{
    use HasFactory;
    protected $table = 'plaza';

    /**
     * Get the empleados for the plaza.
     */
    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class);
    }
}
