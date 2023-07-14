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

<div class="container-fluid  p-0 ">

    <div class="content-main ">
        @include('includes.borders')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">trending_down</i>
                        </div>
                        <h4 class="card-title">Registrar nuevo gasto</h4>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-4 mt-5">
                                    <label for="title">Concepto</label>
                                    <input type="text" class="form-control" name="concept" value="{{ old('concept') }}">
                                    @error('concept')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 mt-5">
                                    <label for="price">Cantidad</label>
                                    <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" step="0.01">
                                    @error('amount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="category">Categoria</label>
                                    <select class="form-control" name="category">
                                        <option selected disabled value="">Selecciona...</option>
                                        @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }} ({{ $category->description}})
                                        </option>

                                        @endforeach
                                        @endif
                                    </select>
                                    @error('category')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-10 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="reset" class="btn">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.borders')

    </div>


</div>





@endsection