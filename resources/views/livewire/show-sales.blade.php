<div class="content p-0">

    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon ">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title font-weight-bold">Resumen de compra - {{$order->folio}}
                                    <a class="btn  btn-link  p-0" href="{{ route('sales.edit', $order->id) }}" target="_blank">
                                        <i class="material-icons text-success">edit</i>
                                    </a>
                                </h4>
                                <span class="text-muted">Email: <b>{{ $order->email }}</b></span>
                                <br>
                                <span class="text-muted">Contacto: <b>{{ $order->socialNetwork }}</b></span>
                                <br>
                                <span class="text-muted">Fecha: <b>{{ date_format($order->created_at, 'd-M-Y H:i') }}</b></span>
                                <br>
                                <span class="text-muted">Total: <b>{{ $order->amount }} MXN</b></span>

                            </div>

                        </div>
                    </div>
                    <div class="card-body row ">
                        <div class="col-12 col-lg-9">
                            <div class="row">
                                <!-- Content -->
                                <div class="rgba-black-strong ">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12">

                                            <!--Accordion wrapper-->
                                            <div class="accordion md-accordion accordion-5 " id="accordionEx5" role="tablist" aria-multiselectable="true">

                                                <!-- Accordion card -->
                                                <div class="card mb-4  mt-0">

                                                    <!-- Card header -->
                                                    <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading30">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse30" aria-expanded="true" aria-controls="collapse30">
                                                            <i class="fa-solid fa-book fa-2x p-3 mr-4 float-left black-text"></i>
                                                            <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                                                Cuadernillos ({{$purchases->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <!-- Card body -->
                                                    <div id="collapse30" class="collapse {{$purchases->count() > 0 ?'show':''}}  " role="tabpanel" aria-labelledby="heading30" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if (isset($purchases) && $purchases->count() > 0)

                                                            @foreach($purchases as $product)
                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($product->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $product->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $product->price }} </b> <br>
                                                                    </p>
                                                                </div>
                                                                <div class="col-12 col-md-3 text-center align-self-center">

                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-primary btn-round w-100" wire:click.prevent="resend('{{ $product->id }}','Product')">
                                                                            Reenviar
                                                                        </button>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click.prevent="download('{{ $product->id }}')">
                                                                            <i class="material-icons">download</i> Descargar
                                                                        </button>
                                                                    </div>



                                                                    <button class="btn btn-outline-primary btn-round w-100" type="button" disabled wire:loading wire:target="resend">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        enviando...
                                                                    </button>

                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>


                                                                </div>
                                                                <div class="col-12">
                                                                    @if(isset($enviados) && $enviados->count() > 0)

                                                                    <table class="table table-hover table-responsive ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><b>Email</b></th>
                                                                                <th><b>Fecha de envio</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="h5 ">
                                                                            @foreach($enviados as $enviado)
                                                                            @if ($enviado->product_id== $product->id && $enviado->order_id== $order->id)
                                                                            <tr>
                                                                                <td>{{$enviado->emal}}</td>
                                                                                <td>{{$enviado->created_at}}</td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    @endif
                                                                </div>


                                                            </div>
                                                            <hr style="border: solid 1px red;">
                                                            @endforeach
                                                            @endif
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
                                                                Paquetes ({{$packages->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse31" class="collapse {{$packages->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading31" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($packages) && $packages->count() > 0)
                                                            @foreach($packages as $package)
                                                            <div class="row pt-2">
                                                                <div class="col-md-3 my-1">
                                                                    <img src="{{ Storage::url($package->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $package->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $package->price }} </b> <br>
                                                                    </p>
                                                                </div>
                                                                <div class="col-12 col-md-3 text-center align-self-center">
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-primary btn-round w-100" wire:click.prevent="resend('{{ $package->id }}','Package')">
                                                                            Reenviar paquete
                                                                        </button>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click="showPackages('{{ $package->id }}')">
                                                                            ver materiale
                                                                        </button>
                                                                    </div>

                                                                    <button class="btn btn-outline-primary btn-round w-100" type="button" disabled wire:loading wire:target="resend">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        enviando...
                                                                    </button>

                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>

                                                                </div>

                                                            </div>
                                                            {{$package->products1}}
                                                            <hr class="text-muted">

                                                            @endforeach
                                                            @endif
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
                                                                Membresías ({{$memberships->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse32" class="collapse {{$memberships->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($memberships) && $memberships->count() > 0)
                                                            @foreach($memberships as $membership)


                                                            <div class="row pt-2">
                                                                <div class="col-md-3 my-1">
                                                                    <img src="{{ Storage::url($membership->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $membership->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $membership->price }} </b> <br>
                                                                    </p>
                                                                    <div class="togglebutton">
                                                                        <label>
                                                                            <input wire:click="updateTarjet1({{ $membership->idOrder }})" type="checkbox" {{ $membership->tarjeta == 1 ? 'checked ' : '' }} name="tarjeta">
                                                                            <span class="toggle"></span>
                                                                            Web
                                                                        </label>
                                                                    </div>
                                                                    <div class="togglebutton">
                                                                        <label>
                                                                            <input wire:click="updateAgenda1({{ $membership->idOrder }})" type="checkbox" {{ $membership->agenda == 1 ? 'checked ' : '' }} name="agenda">
                                                                            <span class="toggle"></span>
                                                                            Agenda
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-3 ">
                                                                    <input id="nota{{ $membership->id }}" style="padding-top:0; padding-bottom:0; border:none; width:150px " class="border text-muted rounded" type="text" value="{{ $membership->nota }}">
                                                                    <button class="btn btn-info btn-link text-success " onclick="udateData('{{ $membership->idOrder }}','{{ $membership->folio }}','nota{{ $membership->id }}')">
                                                                        <i class=" material-icons ">save</i>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                            <hr class="text-muted">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->
                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading32">
                                                        <a data-toggle="collapse" data-parent="#accordionEx6" href="#collapse33" aria-expanded="true" aria-controls="collapse33">
                                                            <i class="fas fa-duotone fa-list fa-2x p-3 mr-4 float-left black-text"></i>
                                                            <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                                                Productos del paquete ({{$productsPackagesOrder->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse33" class="collapse {{$productsPackagesOrder->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx6">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($productsPackagesOrder) && $productsPackagesOrder->count() > 0)
                                                            @foreach($productsPackagesOrder as $product)
                                                            <div class="row pt-2">
                                                                <div class="col-md-3 my-1">
                                                                    <img src="{{ Storage::url($product->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $product->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $product->price }} </b> <br>
                                                                        @if($product->status==0)
                                                                        <b class="text-danger">Product disabled </b> <br>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="col-12 col-md-3 text-center align-self-center">
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-primary btn-round w-100" wire:click.prevent="resend('{{ $product->id }}','Product')">
                                                                            Reenviar
                                                                        </button>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click.prevent="download('{{ $product->id }}')">
                                                                            <i class="material-icons">download</i> Descargar
                                                                        </button>
                                                                    </div>



                                                                    <button class="btn btn-outline-primary btn-round w-100" type="button" disabled wire:loading wire:target="resend">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        enviando...
                                                                    </button>

                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>


                                                                </div>
                                                                <div class="col-12">
                                                                    @if(isset($enviados) && $enviados->count() > 0)

                                                                    <table class="table table-hover table-responsive ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><b>Email</b></th>
                                                                                <th><b>Fecha de envio</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="h5 ">
                                                                            @foreach($enviados as $enviado)
                                                                            @if ($enviado->product_id== $product->id )
                                                                            <tr>
                                                                                <td>{{$enviado->emal}}</td>
                                                                                <td>{{$enviado->created_at}}</td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    @endif
                                                                </div>


                                                            </div>
                                                            <hr style="border: solid 1px red;">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->
                                            </div>
                                            <!--/.Accordion wrapper-->

                                        </div>
                                    </div>
                                </div>
                                <!-- Content -->

                            </div>


                        </div>
                        <div class="col-12 col-lg-3">
                            <img class="w-100 border rounded" src="{{ isset($order) ? Storage::url($order->receiptPayment):'' }}" alt="">
                        </div>




                    </div>
                </div>
            </div>

        </div>

    </div>


    <script type="text/javascript">
        function udateData(idChange, folio, newNote) {
            //Lanzar evento para actualizar membresia

            nota = $('#' + newNote).val();

            Swal.fire({
                title: "Actualizar",
                text: 'Se va a actualizar la nota del folio: "MACA-' + folio + '", Nota: "' + nota + '"',
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, actualizar!",
            }).then((result) => {
                if (result.value) {
                    Livewire.emit('udateData1', idChange, nota);
                }
            });
        }
    </script>
</div>