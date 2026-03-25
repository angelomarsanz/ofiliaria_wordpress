@extends('layout')
@section('title')
    - Listado
@endsection
@section('body')
    @if($msj = Session::get('success'))
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="alert alert-success">
                    <p>{{$msj}}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="container mt-3">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($pruebas as $indice => $prueba)
                <tr>
                    <td>{{$indice+1}}</td>
                    <td>{{$prueba->nombre}}</td>
                    <td><img class='img-fluid'width='120' src='http://localhost/ofiliaria/backend_ofiliaria/public/storage{{$prueba->imagen}}'</td>
                    <td>
                        <a class='btn btn-warning' href='{{route("pruebas.edit", $prueba->id)}}'>
                        Editar
                        </a>
                    </td>
                    <td>
                        <form id='frm_{{$prueba->id}}' method='POST' action='{{route("pruebas.destroy", $prueba->id)}}'>
                            @method('DELETE')
                            @csrf 
                            <button type='submit' class='btn btn-danger'>
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
        </table>
    </div>
@endsection