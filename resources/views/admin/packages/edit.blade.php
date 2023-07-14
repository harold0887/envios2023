@extends('layouts.app',[
'title'=>'Paquetes',
'navbarClass'=>'navbar-transparent',
'activePage'=>'package',
])
@section('content')
<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">library_add</i>

                        </div>
                        <h4 class="card-title">Editar {{ $package->title }}</h4>
                    </div>
                    <div class="card-body ">
                        <form id="edit-package" action="{{ route('package.update',$package->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating" for="title">Titulo</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title')?:$package->title }}">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating" for="price">Precio publico</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price')?:$package->price }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                              
                               
                            </div>
                            
                            <div class="form-row border-bottom text-center mt-5">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Imagen principal</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                        @if ($package->itemMain)
                                            <img src="{{ Storage::url($package->itemMain)  }}" alt="...">
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Selecciona La portada</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="itemMain" accept="image/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('itemMain')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                              
                            </div>
                        </form>
                    </div>
                    <div class="card-body ">
                    <livewire:edit-packages />

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@include('includes.alert-error')