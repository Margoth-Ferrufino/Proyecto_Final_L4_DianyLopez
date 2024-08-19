<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
