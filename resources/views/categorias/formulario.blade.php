@extends('plantilla')
@section('titulo', isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría')
@section('contenido')
    <div class="card mt-2">
        <div class="card-header">
            {{ isset($categoria) ? 'Actualizar Categoría' : 'Crear Categoría' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($categoria) ? route('categorias.update', $categoria->id) : route('categorias.store') }}" method="POST">
                @csrf
                @if(isset($categoria))
                    @method('PUT') <!-- Utiliza el método PUT para la actualización -->
                @endif

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la Categoría</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', isset($categoria) ? $categoria->nombre : '') }}" required>
                    <!-- Utiliza old() para mantener el valor ingresado en caso de error de validación -->
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($categoria) ? 'Actualizar' : 'Crear' }}
                </button>
            </form>
        </div>
    </div>
@endsection
