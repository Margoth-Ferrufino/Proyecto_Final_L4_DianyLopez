<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition()
    {
        return [
            'contenido' => $this->faker->text,
            'user_id' => User::factory(),
            'publicacion_id' => Publicacion::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
