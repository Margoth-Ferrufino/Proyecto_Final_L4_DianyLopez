<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todas las categorías para mostrarlas en el filtro
        $categorias = Categoria::all();

        // Obtener la categoría seleccionada del formulario de filtro
        $categoriaId = $request->input('categoria');

        // Filtrar las publicaciones por la categoría seleccionada, si se seleccionó alguna
        if ($categoriaId) {
            $publicaciones = Publicacion::whereHas('categorias', function ($query) use ($categoriaId) {
                $query->where('categorias.id', $categoriaId);
            })->paginate(10);
        } else {
            // Si no se seleccionó ninguna categoría, mostrar todas las publicaciones
            $publicaciones = Publicacion::paginate(10);
        }

        return view('publicaciones.index', ['publicaciones' => $publicaciones, 'categorias' => $categorias, 'categoriaSeleccionada' => $categoriaId]);
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('publicaciones.formulario', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'categoria' => 'required|array',
            'categoria.*' => 'exists:categorias,id',
        ]);

        $publicacion = new Publicacion();
        $publicacion->titulo = $request->input('titulo');
        $publicacion->contenido = $request->input('contenido');
        $publicacion->user_id = auth()->id(); // Asignar el ID del usuario autenticado

        if ($publicacion->save()) {
            $publicacion->categorias()->sync($request->input('categoria'));
            return redirect()->route('publicaciones.index')->with('exito', 'La publicación se guardó correctamente');
        } else {
            return redirect()->route('publicaciones.index')->with('error', 'La publicación no se pudo guardar.');
        }
    }

    public function show($id)
    {
        $publicacion = Publicacion::with(['categorias', 'comentarios', 'usuario'])->findOrFail($id);
        return view('publicaciones.show', compact('publicacion'));
    }

    public function edit($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $categorias = Categoria::all();
        return view('publicaciones.formulario', compact('publicacion', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'categoria' => 'required|array',
            'categoria.*' => 'exists:categorias,id',
        ]);

        $publicacion = Publicacion::findOrFail($id);
        $publicacion->titulo = $request->input('titulo');
        $publicacion->contenido = $request->input('contenido');

        if (!$publicacion->user_id) {
            $publicacion->user_id = auth()->id();
        }

        if ($publicacion->save()) {
            $publicacion->categorias()->sync($request->input('categoria'));
            return redirect()->route('publicacion.show', $publicacion->id)->with('exito', 'La publicación se actualizó correctamente');
        } else {
            return redirect()->route('publicacion.edit', $publicacion->id)->with('error', 'La publicación no se pudo actualizar.');
        }
    }

    public function destroy($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if (auth()->user()->administrador || auth()->id() === $publicacion->user_id) {
            $eliminado = $publicacion->delete();

            if ($eliminado) {
                return redirect()->route('publicaciones.index')->with('exito', 'La publicación se eliminó correctamente');
            } else {
                return redirect()->route('publicaciones.index')->with('error', 'La publicación no se pudo eliminar.');
            }
        }

        return redirect()->route('publicaciones.index')->with('error', 'No tienes permiso para eliminar esta publicación.');
    }
}
