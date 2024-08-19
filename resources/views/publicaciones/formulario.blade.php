@extends('plantilla')
@section('titulo', 'Nueva Publicación')
@section('contenido')
    <div class="card mt-2">
        <div class="card-header">
            {{ isset($publicacion) ? 'Actualizar Publicación' : 'Crear Publicación' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($publicacion) ? route('publicacion.update', $publicacion->id) : route('publicaciones.store') }}" method="POST">
                @csrf
                @if(isset($publicacion))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', isset($publicacion) ? $publicacion->titulo : '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea class="form-control" id="contenido" name="contenido" rows="5" required>{{ old('contenido', isset($publicacion) ? $publicacion->contenido : '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria" name="categoria[]" multiple required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ isset($publicacion) && $publicacion->categorias->contains($categoria->id) ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Puedes seleccionar múltiples categorías manteniendo presionada la tecla Ctrl (Cmd en Mac) y haciendo clic en las opciones.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($publicacion) ? 'Actualizar' : 'Crear' }}
                </button>
            </form>
        </div>
    </div>
@endsection
