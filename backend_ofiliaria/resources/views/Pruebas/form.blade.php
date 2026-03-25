@extends('layout')
@section('title')
    - @yield('formName')
@endsection
@section('body')
    @if($errors->any())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p><b> Errores</b></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    <div class='row'>
        <div class='col-12'>
            <div class='card'>
                <div class='card-header'>@yield('forName')</div>
                <div class='card-body'>
                    <form @yield('action') method='post' enctype='multipart/form-data'>
                        @yield('method')
                        @csrf
                        <div class='input-group mb-3'>
                            <span class='input-group-text'>Nombre</span>
                            <input type='text' name='nombre' class='form-control' placeholder='Nombre'                @isset($prueba) value        ={{$prueba->nombre}}          
                            @endisset required>
                        </div>
                        <div class='input-group mb-3'>
                            <span class='input-group-text'>Imagen</span>
                            <input type='file' name='imagen' class='form-control' accept='image/png, image/jpg, image/jpeg' @if(!isset($prueba)) required @endif>
                        </div>
                        <button class='btn btn-success' type='submit'> Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection