@extends('plantilla')
@section('titulo', 'Ver Publicacion')
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
    <div class="card mt-3">
        <h5 class="card-header">
            {{ $publicacion->titulo }}
            <small class="text-muted">Publicado por {{ $publicacion->usuario->name }}</small>
        </h5>
        <div class="card-body">
            <p class="card-text">{{ $publicacion->contenido }}</p>

            <!-- Categorías de la publicación -->
            <p class="card-text"><strong>Categorías:</strong>
                @forelse($publicacion->categorias as $categoria)
                    <span class="badge bg-secondary">{{ $categoria->nombre }}</span>
                @empty
                    <span class="badge bg-secondary">No hay categorías</span>
                @endforelse
            </p>

            <!-- Botones de edición y eliminación -->
            @if(auth()->check() && (auth()->id() === $publicacion->user_id || auth()->user()->administrador))
                <a href="{{ route('publicacion.editar', $publicacion->id) }}" class="btn btn-primary">Editar</a>

                <!-- Botón de eliminar con modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar">
                    Eliminar
                </button>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
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
            @endif
        </div>
    </div>

    <!-- Sección de comentarios con acordeón -->
    <div class="mt-4">
        <h4>Comentarios</h4>
        @forelse($publicacion->comentarios as $comentario)
            <div class="card mb-2">
                <div class="card-body">
                    <p><strong>{{ $comentario->usuario->name ?? 'Usuario desconocido' }}</strong></p>
                    <p>{{ $comentario->contenido }}</p>
                </div>
            </div>
        @empty
            <p>No hay comentarios aún.</p>
        @endforelse
    </div>

    <!-- Formulario para agregar un comentario -->
    @auth
        <div class="card mt-4">
            <h5 class="card-header">Agregar Comentario</h5>
            <div class="card-body">
                <form action="{{ route('comentarios.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="publicacion_id" value="{{ $publicacion->id }}">
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido</label>
                        <textarea name="contenido" id="contenido" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </form>
            </div>
        </div>
    @endauth
@endsection
