@extends('plantilla')
@section('titulo', 'Publicaciones')

@section('contenido')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex justify-center text-center mb-3">
        <h1>Todas las publicaciones</h1>
    </div>

    <!-- Filtro de categorías -->
    <div class="flex justify-center mb-4">
        <form action="{{ route('publicaciones.index') }}" method="GET">
            <div class="flex items-center">
                <label for="categoria" class="mr-2">Filtrar por categoría:</label>
                <select name="categoria" id="categoria" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $categoria->id == $categoriaSeleccionada ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary ml-2">Filtrar</button>
            </div>
        </form>
    </div>

    @auth
        <div class="flex mb-2 justify-end">
            <a href="{{ route('publicaciones.crear') }}" class="btn btn-outline-primary">Crear Nueva Publicacion</a>
            @if(auth()->check() && auth()->user()->administrador)
                <a href="{{ route('categorias.create') }}" class="btn btn-outline-secondary">Crear Categoría</a>
            @endif
        </div>
    @endauth

    @forelse($publicaciones as $publicacion)
        <div class="card text-center mb-3 border border-green-500 rounded-lg shadow-sm">
            <div class="card-header bg-gray-100 text-lg font-semibold">
                {{$publicacion->titulo}}
            </div>
            <div class="card-body p-4">
                <p class="card-text">{{ $publicacion->contenido }}</p>
                <a href="{{ route('publicacion.show', ['id' => $publicacion->id])}}" class="btn btn-primary bg-green-600 hover:bg-green-700">Ver publicacion</a>
            </div>
            <div class="card-footer text-gray-500 text-sm">
                Publicado por: {{ $publicacion->usuario->name }} | {{ $publicacion->created_at->format('d M Y') }}
            </div>
            <!-- Botones de editar y eliminar -->
            @if(auth()->check() && (auth()->id() === $publicacion->user_id || auth()->user()->administrador))
                <div class="card-footer text-right">
                    <a href="{{ route('publicacion.editar', $publicacion->id) }}" class="btn btn-primary">Editar</a>

                    <!-- Botón de eliminar con modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar{{$publicacion->id}}">
                        Eliminar
                    </button>

                    <!-- Modal de confirmación -->
                    <div class="modal fade" id="modalEliminar{{$publicacion->id}}" tabindex="-1" aria-labelledby="modalEliminarLabel{{$publicacion->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEliminarLabel{{$publicacion->id}}">Confirmar eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar esta publicación?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('publicacion.destroy', $publicacion->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @empty
        <h1>No hay publicaciones</h1>
    @endforelse

    {{$publicaciones->links()}}
@endsection
