<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public function publicaciones()
    {
        return $this->belongsToMany(Publicacion::class, 'categoria_publicacion', 'categoria_id', 'publicacion_id');
    }
}
