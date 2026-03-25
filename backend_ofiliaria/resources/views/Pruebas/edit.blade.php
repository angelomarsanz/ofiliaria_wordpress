@extends('Pruebas.form')
@section('formName')
    Editar a <b>{{$prueba->nombre}}</b>
@endsection
@section('action')
    action = '{{route('pruebas.update', $prueba)}}'
@endsection
@section('method') 
    @method('PUT')
@endsection
