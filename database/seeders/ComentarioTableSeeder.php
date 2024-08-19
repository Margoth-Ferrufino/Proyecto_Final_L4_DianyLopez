<?php

namespace Database\Seeders;

use App\Models\Comentario;
use Illuminate\Database\Seeder;

class ComentarioTableSeeder extends Seeder
{
    public function run()
    {
        Comentario::factory(15)->create();
    }
}
