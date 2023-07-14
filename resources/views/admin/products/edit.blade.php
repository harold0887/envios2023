@extends('layouts.app',[
'title'=>'Productos',
'navbarClass'=>'navbar-transparent',
'activePage'=>'products',
])
@section('content')
<div class="content pt-0">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Editar {{ $product->title }}</h4>
                    </div>
                    <div class="card-body ">
                    <form id="edit-product" action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PATCH')
                            <div class="form-row ">
                                <div class="form-group col-12 col-md-4">
                                    <label class="bmd-label-floating">Titulo</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title')?:$product->title }}">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label class="bmd-label-floating">Precio publico</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price')?:$product->price }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title ">Documento</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            @if (Storage::exists($product->document))
                                            <img src="{{ asset('img') }}/docs/{{$product->format}}.png" alt="...">
                                            <h6 class="m-2">{{$product->title}}.{{ $product->format }}</h6>

                                            @else

                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existe un documento para este producto.</h6>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Selecciona el documento</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="document" accept=".doc,.docx,.pdf,.ppt,.pptx,.ppxs " />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('document')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Imagen principal</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                        <div class="fileinput-new thumbnail">
                                            @if (Storage::exists($product->itemMain))
                                            <img src="{{ Storage::url($product->itemMain)  }}" alt="...">
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existe una portada para este producto.</h6>
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
                            <div class="col-sm-10 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @include('includes.alert-error')