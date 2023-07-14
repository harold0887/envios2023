@extends('layouts.app',[
'title'=>'Productos',
'navbarClass'=>'navbar-transparent',
'activePage'=>'products',
])
@section('content')
<livewire:index-products />



@endsection
@include('includes.alert-error')