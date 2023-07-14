@extends('layouts.app',[
'title'=>'Paquetes',
'navbarClass'=>'navbar-transparent',
'activePage'=>'package',
])
@section('content')
<livewire:index-packages />



@endsection
@include('includes.alert-error')