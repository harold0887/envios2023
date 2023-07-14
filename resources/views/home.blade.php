@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'home',
'title' =>"Inicio",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')

<livewire:home-render />






@endsection
