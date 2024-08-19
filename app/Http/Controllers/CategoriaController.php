<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::paginate(10);
        return(view('categorias.index', ['categorias' => $categorias ]));
    }

    public function create()
    {
        return view('categorias.formulario');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->input('nombre');

        if ($categoria->save()) {
            return redirect()->route('categorias.index')->with('exito', 'La categoría se guardó correctamente');
        } else {
            return redirect()->route('categorias.index')->with('error', 'La categoría no se pudo guardar.');
        }
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.formulario', ['categoria' => $categoria]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->input('nombre');

        if ($categoria->save()) {
            return redirect()->route('categorias.index')->with('exito', 'La categoría se actualizó correctamente');
        } else {
            return redirect()->route('categorias.index')->with('error', 'La categoría no se pudo actualizar.');
        }
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->delete()) {
            return redirect()->route('categorias.index')->with('exito', 'La categoría se eliminó correctamente');
        } else {
            return redirect()->route('categorias.index')->with('error', 'La categoría no se pudo eliminar.');
        }
    }
}
