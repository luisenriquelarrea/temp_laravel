<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';

    /**
     * Get the post that owns the comment.
     */
    public function plaza(): BelongsTo
    {
        return $this->belongsTo(Plaza::class);
    }
}
