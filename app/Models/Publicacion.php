<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function Categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_publicacion', 'publicacion_id', 'categoria_id');
    }

}
