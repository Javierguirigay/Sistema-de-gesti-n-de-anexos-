<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Asignatura extends Model
{
    use HasFactory;

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user__asignatura');
    }

    public function secciones(): HasMany
    {
        return $this->hasMany(Seccion::class);
    }
}
