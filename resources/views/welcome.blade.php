@extends('layout')

@section('title', "Crear usuario")

@section('content')
    @component('shared._card')
        @slot('header', 'Welcome Panel Control')

        <div class="container center-block" >
            <img src="{{ asset('images/github-heroku.jpeg') }}" alt="" class="">
        </div>
    @endcomponent
@endsection