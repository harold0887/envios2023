@extends('layouts.app',[
'title'=>'Productos',
'navbarClass'=>'navbar-transparent',
'activePage'=>'memberships',
])
@section('content')
<livewire:index-memberships />



@endsection
@include('includes.alert-error')