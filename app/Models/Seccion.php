<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seccion extends Model
{
    use HasFactory;

    public function asignatura(): BelongsTo
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user__seccion');
    }

    public function anexos(): HasMany
    {
        return $this->hasMany(Anexo::class);
    }
}
