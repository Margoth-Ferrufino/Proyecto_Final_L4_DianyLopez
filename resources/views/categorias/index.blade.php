@extends('plantilla')
@section('titulo', 'Página Inicial - Categorías')

@section('contenido')
    {{-- Mostrar mensajes de error o de éxito si se pasaron correctamente los datos --}}
    @if(session('exito'))
        <div class="alert alert-success" role="alert">
            {{ session('exito') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Título de la página --}}
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="my-2"><strong>Lista de Categorías</strong></h1>
    </div>

    {{-- Botón para ir al formulario de crear una categoría --}}
    @if(auth()->check() && auth()->user()->administrador)
        <a class="btn btn-primary mx-5 mb-3" href="{{ route('categorias.create') }}">+Nueva Categoría</a>
    @endif

    {{-- Contenedor de la tabla --}}
    <div class="container">
        <table class="table table-danger table-striped">
            {{-- Columnas con sus respectivos encabezados --}}
            <thead>
            <tr>
                <th scope="col" colspan="2">ID</th>
                <th scope="col" colspan="8">Nombre de la Categoría</th>
                <th scope="col" colspan="1"></th>
                <th scope="col" colspan="1"></th>
                <th scope="col" colspan="1"></th>
            </tr>
            </thead>

            {{-- Aquí se empiezan a pasar los datos --}}
            <tbody>
            {{-- El $categorias es la variable que pasamos en el controlador, usamos as $categoria, para que se lea un solo dato, y se coloque en cada fila --}}
            @forelse($categorias as $categoria)
                {{-- Cada tr es una fila --}}
                <tr>
                    <th scope="row" colspan="2">{{ $categoria->id }}</th>
                    <td colspan="8">{{ $categoria->nombre }}</td>

                    {{-- Botón de editar --}}
                    @if(auth()->check() && auth()->user()->administrador)
                        <td colspan="1">
                            <a class="btn btn-warning mx-5" href="{{ route('categorias.edit', ['id' => $categoria->id]) }}">Editar</a>
                        </td>
                    @endif

                    {{-- Modal para eliminar datos --}}
                    @if(auth()->check() && auth()->user()->administrador)
                        <td colspan="1">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEliminar{{ $categoria->id }}">
                                Eliminar
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalEliminar{{ $categoria->id }}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                Eliminar {{ $categoria->nombre }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Quiere eliminar la categoría {{ $categoria->nombre }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cerrar
                                            </button>

                                            {{-- Formulario para eliminar --}}
                                            <form method="post" action="{{ route('categorias.destroy', ['id' => $categoria->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Eliminar" class="btn btn-danger">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Fin del modal --}}
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">No hay categorías</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    {{ $categorias->links() }}
@endsection
