<div class="container-fluid  p-0 ">

    <div class="content-main ">
        @include('includes.borders')

        <div class="row my-3 rounded mx-1 shadow bg-white">
            <div class="col-12 col-md-5">
                <label for="year">Selecciona una membresia</label>
                <select class="form-control" name="fop" wire:model="membershipSelect">
                    <option selected value="" disabled>Selecciona una opcion...</option>
                    @if(isset($membresias) && $membresias->count() > 0)
                    @foreach($membresias as $membresia)
                    <option value="{{$membresia->id}}">{{$membresia->title}}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="col-12 col-md-3">
                @if($search!='')
                <div class="alert alert-light alert-dismissible fade show mt-5 " role="alert" style="padding: 0 !important;">
                    Borrar filtros
                    <button style="padding: 0 !important;" type="button" class="close text-danger" data-dismiss="alert" aria-label="Close" wire:click="clearFilters()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>



            @if ($membershipSelect != '')
            <div class="col-12 col-md-4">
                <label for="year">Buscar</label>
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Buscar por folio, email, whatsapp o facebook" wire:model.lazy='search' />
                    <span class="input-group-text border-0 pt-2 px-0">
                        <i class="material-icons">search</i>
                    </span>
                </div>
            </div>
            <div class="col-12">
                <small class="text-primary">{{ $shipments->count() }} resultados obtenidos</small> -
                <small class="text-muted">{{ $sinRegistro->count() }} registrados en web</small>
            </div>
            @endif
        </div>


        @if(isset($shipments) && $shipments->count() > 0)
        <div class="row mt-3">


        </div>
        <div class="row  mt-3 border rounded mx-1 shadow">

            <div class="col-12">
                <div class="table-responsive ">
                    <table class="table table-hover table-sm ">
                        <thead>
                            <tr>
                                <th><b>Folio venta</b></th>
                                <th><b>Fecha venta</b></th>
                                <th><b>email</b></th>
                                <th><b>Red social</b></th>
                                <th><b>Web</b></th>
                                <th><b>Agenda</b></th>
                                <th><b>Nota</b></th>
                                <th><b>Acciones</b></th>
                            </tr>
                        </thead>
                        <tbody class="h5 ">
                            @foreach ($shipments as $shipment)
                            <tr class="  {{ $shipment->tarjeta == 0 ? 'table-danger ' : '' }}">


                                <td>{{ $shipment->folio }}</td>
                                <td> {{date_format($shipment->created_at, 'd-M-Y')}}</td>
                                <td>{{ $shipment->email }}</td>
                                <td>{{ $shipment->socialNetwork }}</td>

                                <td>
                                    <div class="togglebutton">
                                        <label>
                                            <input wire:click="updateTarjet({{ $shipment->id }})" type="checkbox" {{ $shipment->tarjeta == 1 ? 'checked ' : '' }} name="tarjeta">
                                            <span class="toggle"></span>
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <div class="togglebutton">
                                        <label>
                                            <input wire:click="updateAgenda({{ $shipment->id }})" type="checkbox" {{ $shipment->agenda == 1 ? 'checked ' : '' }} name="agenda">
                                            <span class="toggle"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <input id="nota{{ $shipment->id }}" style="padding-top:0; padding-bottom:0; border:none; width:150px " class="border text-muted rounded" type="text" value="{{ $shipment->nota }}">
                                </td>
                                <td>
                                    <button class="btn btn-info btn-link text-success " onclick="udateData('{{ $shipment->id }}','{{ $shipment->folio }}','nota{{ $shipment->id }}')">
                                        <i class=" material-icons ">save</i>
                                    </button>


                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>





            </div>
        </div>
        @endif


        @include('includes.borders')




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
                    Livewire.emit('udateData', idChange, nota);
                }
            });
        }

        function confirmUpdateAgenda($id, $folio) {
            Swal.fire({
                title: "Actualizar",
                text: 'Realmente desea confirmar la entrega de la agenda para el folio:' + $folio,
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, actualizar!",
            }).then((result) => {
                if (result.value) {
                    Livewire.emit("updateAgenda", $id);
                }
            });
        }

        function confirmUpdateTarjet($id, $folio) {
            Swal.fire({
                title: "Actualizar",
                text: 'Realmente desea confirmar la entrega de la tarjeta para el folio:' + $folio,
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, actualizar!",
            }).then((result) => {
                if (result.value) {
                    Livewire.emit("updateTarjet", $id);
                }
            });
        }
    </script>
</div>