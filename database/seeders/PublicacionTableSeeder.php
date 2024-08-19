<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use Illuminate\Database\Seeder;

class PublicacionTableSeeder extends Seeder
{
    public function run()
    {
        Publicacion::factory(20)->create();
    }
}
