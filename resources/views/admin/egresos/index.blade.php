@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'movimientos',
'title' =>"Egresos",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')

<livewire:egresos/>






@endsection
