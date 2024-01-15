<div class="content p-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Ventas ({{$orders->total()}} registros)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-8   align-self-md-center">
                                    <div class="input-group rounded ">
                                    <input id="input-search" type="search" class="form-control px-3" placeholder="Buscar por orden, email, etc..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                        @if ($search != '')
                                        <span class="input-group-text" style="cursor:pointer" wire:click="clearSearch()"><i class="material-icons mx-0 text-lg text-danger">close</i></span>
                                        @endif
                                    </div>
                                </div>

                              
                            </div>
                        </div>



                       
                        
                       


                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $orders->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="cursor:pointer" wire:click="setSort('id')">
                                            @if($sortField=='id')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            Id
                                        </th>

                                        <th style="cursor:pointer" wire:click="setSort('created_at')">
                                            @if($sortField=='created_at')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Fecha
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('amount')">
                                            @if($sortField=='amount')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Cantidad
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('socialNetwork')">
                                            @if($sortField=='socialNetwork')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Red Social
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('email')">
                                            @if($sortField=='email')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Email
                                        </th>


                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->folio }}</td>

                                        <td>{{date_format($order->created_at, 'd-M-Y H:i')}}</td>
                                        <td>{{ $order->amount }}</td>
                                        <td>{{ $order->socialNetwork }}</td>
                                        <td>{{ $order->email }}</td>


                                        <td class="td-actions">
                                            <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}">
                                                <i class=" material-icons">visibility</i>
                                            </a>
                                            <a class="btn btn-success btn-link " href="{{ route('sales.edit', $order->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>

                                            <a class="btn btn-success btn-link text-danger " wire:click="deleteOrder({{ $order->id }})">
                                                <i class="material-icons ">close</i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $orders->links() }}
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>