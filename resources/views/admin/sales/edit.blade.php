@extends('layouts.app',[
'title'=>'Ventas',
'navbarClass'=>'navbar-transparent',
'activePage'=>'sales',
])
@section('content')
<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <h4 class="card-title">Editar compra - {{$order->folio}}</h4>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('sales.update',$order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="order">email</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email')?:$order->email  }}">
                                    @error('email')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="socialNetwork">Whats App y/o Facebook</label>
                                    <input type="text" class="form-control" name="socialNetwork" value="{{ old('socialNetwork')?:$order->socialNetwork  }}">
                                    @error('socialNetwork')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="price">Precio</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price')?:$order->amount }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="date">Fecha de venta</label>
                                    <input type="date" class="form-control" name="date" required value="{{ old('disponible')?: (new DateTime($order->created_at))->format('Y-m-d')  }}">
                                    @error('date')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>


                            </div>

                            <div class="col-sm-12 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Actualizar</button>

                            </div>
                        </form>
                        <livewire:sales-edit />
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>




@endsection
@include('includes.alert-error')