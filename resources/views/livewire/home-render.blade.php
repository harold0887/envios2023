<div class="container-fluid  p-0 ">

    <div class="content-main ">
        @include('includes.borders')

        <div class="row d-flex justify-content-center">
            <div class="col-12">

                <!--Accordion wrapper-->
                <div class="accordion md-accordion accordion-5" id="accordionEx5" role="tablist" aria-multiselectable="true">

                    <!-- Accordion card -->
                    <div class="card mb-4">

                        <!-- Card header -->
                        <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading30">
                            <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse30" aria-expanded="true" aria-controls="collapse30">
                                <i class="fa-solid fa-list fa-2x p-3 mr-4 float-left black-text"></i>
                                <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                    Cuadernillos
                                </h4>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapse30" class="collapse show" role="tabpanel" aria-labelledby="heading30" data-parent="#accordionEx5">
                            <div class="card-body rgba-black-light white-text z-depth-1">
                                <div class="form-row align-items-center">
                                    @foreach ($products as $product)
                                    <div class="col-4 col-md-2 p-1">
                                        <div class=" rounded shadow">
                                            <div class="row ">
                                                <div class="col-12">
                                                    <img class="w-100 rounded" src="{{ Storage::url($product->itemMain) }} ">
                                                </div>
                                            </div>
                                            <div class="row px-2">
                                                <div class="col-12 col-lg-6 text-center">
                                                    <p class="item-price text-muted p-0 ">$ {{ $product->price }}
                                                        <a class="btn btn-success btn-link p-0 " href="{{ route('products.edit', $product->id) }}" target="_blank">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-lg-6 text-end">
                                                    @if(!\Cart::get($product->id))
                                                    <button class=" btn btn-primary btn-fab btn-fab-mini btn-round" wire:click="addCart('{{ $product->id }}','{{ $product->codeSend }}')">
                                                        <i class="material-icons">shopping_cart</i>
                                                    </button>
                                                    @else
                                                    <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round py-1 px-3">
                                                        <span>Ver</span>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->

                    <!-- Accordion card -->
                    <div class="card mb-4">

                        <!-- Card header -->
                        <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading31">
                            <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse31" aria-expanded="true" aria-controls="collapse31">
                                <i class="fas fa-light fa-cubes fa-2x p-3 mr-4 float-left black-text"></i>

                                <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                    Paquetes
                                </h4>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapse31" class="collapse" role="tabpanel" aria-labelledby="heading31" data-parent="#accordionEx5">
                            <div class="card-body rgba-black-light white-text z-depth-1">
                                <div class="form-row align-items-center">
                                    @foreach ($packages as $product)
                                    <div class="col-4 col-md-2 p-1">
                                        <div class=" rounded shadow">
                                            <div class="row ">
                                                <div class="col-12">
                                                    <img class="w-100 rounded" src="{{ Storage::url($product->itemMain) }} ">
                                                </div>
                                            </div>
                                            <div class="row px-2">
                                                <div class="col-12 col-lg-6 text-center">
                                                    <p class="item-price text-muted p-0 ">$ {{ $product->price }}
                                                        <a class="btn btn-success btn-link p-0 " href="{{ route('package.edit', $product->id) }}" target="_blank">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-lg-6 text-end">
                                                    @if(!\Cart::get($product->id))
                                                    <button class=" btn btn-primary btn-fab btn-fab-mini btn-round" wire:click="addCart('{{ $product->id }}','{{ $product->codeSend }}')">
                                                        <i class="material-icons">shopping_cart</i>
                                                    </button>
                                                    @else
                                                    <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round py-1 px-3">
                                                        <span>Ver</span>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->

                    <!-- Accordion card -->
                    <div class="card mb-4">

                        <!-- Card header -->
                        <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading32">
                            <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse32" aria-expanded="true" aria-controls="collapse32">
                                <i class="fas fa-duotone fa-id-card fa-2x p-3 mr-4 float-left black-text"></i>
                                <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                    Membresías
                                </h4>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapse32" class="collapse" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx5">
                            <div class="card-body rgba-black-light white-text z-depth-1">
                                <div class="form-row align-items-center">
                                    @foreach ($memberships as $product)
                                    <div class="col-4 col-md-2 p-1">

                                        <div class=" rounded shadow">
                                            <div class="row ">
                                                <div class="col-12">
                                                    <img class="w-100 rounded" src="{{ Storage::url($product->itemMain) }} ">
                                                </div>
                                            </div>
                                            <div class="row px-2">
                                                <div class="col-12 col-lg-6 text-center">
                                                    <p class="item-price text-muted p-0 ">$ {{ $product->price }}
                                                        <a class="btn btn-success btn-link p-0 " href="{{ route('memberships.edit', $product->id) }}" target="_blank">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-lg-6 text-end">
                                                    @if(!\Cart::get($product->id))
                                                    <button class=" btn btn-primary btn-fab btn-fab-mini btn-round" wire:click="addCart('{{ $product->id }}','{{ $product->codeSend }}')" wire:loading.attr="disabled">
                                                        <i class="material-icons">shopping_cart</i>
                                                    </button>
                                                    @else
                                                    <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round py-1 px-3">
                                                        <span>Ver</span>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                </div>
                <!--/.Accordion wrapper-->

            </div>
        </div>




        @include('includes.borders')




    </div>


</div>