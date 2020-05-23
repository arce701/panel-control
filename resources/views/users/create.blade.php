@extends('layout')

@section('title', "Crear usuario")

@section('content')
    @component('shared._card')
        @slot('header','Crear usuario')

        <form method="POST" action="{{ url('usuarios') }}">
            @include('users._fields')
{{--            @render('UserFields', ['user'=>$user])--}}
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Crear usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
            </div>
        </form>
    @endcomponent
@endsection