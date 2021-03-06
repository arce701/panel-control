@extends('layout')

@section('title', "Crear usuario")

@section('content')
    @component('shared._card')
        @slot('header', 'Editar usuario')

        @include('shared._errors')

        <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
            {{ method_field('PUT') }}
{{--            @include('users._fields')--}}
            @render('UserFields', ['user'=>$user])
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
            </div>
        </form>
    @endcomponent
@endsection