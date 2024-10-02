<div class="container bg-white shadow my-1 rounded ">

    <div class="content-main ">
        @include('includes.spinner-livewire')


        <div class="row justify-content-center p-3">

            @if (\Cart::getContent()->count() > 0)

            <div class="col-10 col-lg-6">

                <span class="h3">
                    Mi carrito
                </span>
                <p class="pb-3 text-sm lg:text-lg">
                    Revise su pedido y luego continúe con el envio.
                </p>
                @foreach (\Cart::getContent() as $item)
                <div class="row">
                    <div class="col-md-3 my-1">
                        <img src="{{ Storage::url($item->associatedModel->itemMain) }} " class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-6 ">
                        <p>

                            <a href="" class="text-dark">
                                <b style="font-size: 1em">{{ $item->name }}</b>
                            </a>
                            <br>

                            <span class="text-muted">Precio: ${{ number_format($item->price,2) }} MXN </span> <br>
                            <span class="text-muted">Cantidad: {{ $item->quantity }} </span> <br>
                        </p>
                    </div>
                    <div class="col-md-3 text-center ">
                        <button type="submit" class="btn  btn-link p-0" wire:click="remove('{{ $item->id }}','{{ $item->associatedModel->codeSend }}')" wire:loading.attr="disabled">
                            <i class="material-icons">close</i>
                            Eliminar
                        </button>
                    </div>
                </div>
                <hr class="text-muted border border-primary">
                @endforeach
            </div>
            <div class="col-3 pt-3">

            </div>
            <div class="col-12 col-lg-3 ">

                <div class="row membership-sticky bg-white rounded shadow ">
                    <div class="col-12    text-center">
                        <span class=" h3">Resumen de la orden</span>
                    </div>
                    <div class="col-7  py-4 text-muted">Subtotal {{ \Cart::getTotalQuantity() }} artículo(s): </div>
                    <div class="col-5 py-4 text-end text-muted">${{ \Cart::getTotal() }} MXN</div>
                    <div class="col-12">
                        <hr class="text-muted">
                    </div>
                    <div class="col-6  font-weight-bold h3">Total: </div>
                    <div class="col-6  font-weight-bold text-end h3">${{ \Cart::getTotal() }} MXN</div>
                    <div class="col-12 pt-3">
                        <input type="text" class="form-control rounded " placeholder="Email" name="email" wire:model.defer="email">
                        @error('email')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>

                    <div class="col-12 pt-3">
                        <input type="text" class="form-control rounded " name="socialNetwork" placeholder="WhatsApp y/o Facebook" wire:model.defer="socialNetwork">
                        @error('socialNetwork')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    <!-- <div class="form-group col-12 pt-3">
                        <select class="form-control" name="fop" wire:model="fop">
                            <option selected value="">Selecciona pago...</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Paypal">Paypal</option>
                            <option value="Mercado Pago">Mercado Pago</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('fop')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    <div class="col-">
                        <div class="togglebutton">
                            <label>
                                <input wire:click="changeWeb()" type="checkbox" {{ $web == 1 ? 'checked ' : '' }}>
                                <span class="toggle"></span>
                                Web
                            </label>
                        </div>
                    </div>
                    @if ( $web == 0)
                    <div class="col-12 pt-3 text-center">

                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                        <div>
                            <span class="btn btn-outline-primary  btn-file   btn-round">
                                <span class="fileinput-new ">Selecciona comprobante</span>
                                <input type="file" name="itemMain" accept="image/*" style="max-width: 100%;" wire:model="payment" />
                            </span>
                        </div>
                        @error('payment')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    @endif

                    <div class="col-12 text-center">
                        @if ($payment)
                        <img class="w-100 rounded shadow" src="{{ $payment->temporaryUrl() }}">
                        @endif
                    </div> -->
                    <div class="col-12 text-center pt-5">
                        <div wire:loading.remove>
                            <button class="btn btn-primary " wire:click="submit">
                                <span>Enviar</span>
                            </button>
                        </div>
                        <button class="btn btn-outline-primary btn-round " disabled wire:loading wire:target="submit">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            enviando...
                        </button>


                    </div>
                </div>
            </div>
            @else
            <div class="col-12 col-lg-5 text-center ">
                <img src="{{ asset('img/cart.png') }} " class="text-center  w-100">
                <a href="{{ route('home') }}" class="btn btn-primary h5">Ir al inicio</a>
            </div>


            @endif

        </div>


    </div>
</div>