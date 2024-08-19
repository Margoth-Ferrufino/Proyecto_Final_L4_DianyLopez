<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PublicacionFactory extends Factory
{
    protected $model = Publicacion::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'contenido' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Publicacion $publicacion) {
            $categoriasCount = rand(1, 5);
            // Asigna entre 1 y 5 categorías a la publicación
            $categorias = Categoria::factory()->count($categoriasCount)->create();
            $publicacion->categorias()->attach($categorias);

            // Crea entre 1 y 5 comentarios para la publicación
            $comentariosCount = rand(1, 5); // Número aleatorio entre 1 y 5
            Comentario::factory()->count($comentariosCount)->create([
                'publicacion_id' => $publicacion->id,
            ]);
        });
    }
}
