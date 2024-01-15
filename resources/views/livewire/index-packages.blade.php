<div class="content pt-0">
    <div class="container-fluid">
        <div class="row ">



            <div class="col-12 ">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">library_add</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Paquetes ({{$packages->total()}} registros)</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-8   align-self-md-center">
                                    <div class="input-group rounded ">
                                        <input id="input-search" type="search" class="form-control px-3" placeholder=" Buscar por titulo..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                        @if ($search != '')
                                        <span class="input-group-text" style="cursor:pointer" wire:click="clearSearch()"><i class="material-icons mx-0 text-lg text-danger">close</i></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-md-auto  align-self-md-center">
                                    <a class="btn btn-primary btn-block " href="{{ route('package.create') }}">
                                        <i class="material-icons">add_circle</i>
                                        <span>Nuevo Paquete</span>
                                    </a>
                                </div>
                            </div>
                        </div>




                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $packages->count() }} resultados obtenidos</small>

                            @endif
                        </div>

                        @if (isset($packages) && $packages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="cursor:pointer" wire:click="setSort('name')">
                                            @if($sortField=='name')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            Nombre
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('price')">
                                            @if($sortField=='price')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Precio
                                        </th>

                                        <th style="cursor:pointer" wire:click="setSort('products_count')">
                                            @if($sortField=='products_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Materiales
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('status')">
                                            @if($sortField=='status')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Status
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('sales_count')">
                                            @if($sortField=='sales_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Ventas
                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $product)
                                    <tr class="{{ $product->percentage >0 ?'text-danger':'' }}">

                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>


                                        <td>{{ $product->products->count() }}</td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeStatusPackage({{ $product->id }}, '{{ $product->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $product->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $product->sales_count }}
                                        </td>
                                        <td class="td-actions">
                                            <div class="btn-group m-0 d-flex" style="box-shadow: none !important">

                                                <a href="{{ route('package.edit', $product->id) }}">
                                                    <button type="button" rel="tooltip" class="btn btn-success btn-link d-inline" data-original-title="" title="">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </a>
                                                <form method="post" action="{{ route('package.destroy', $product->id) }} ">
                                                    <input type="text" hidden value="{{$product->title}}">
                                                    <button class=" btn btn-danger btn-link btn-icon btn-sm remove show-alert-delete-package">
                                                        @csrf
                                                        @method('DELETE')
                                                        <i class="material-icons ">close</i>
                                                    </button>
                                                </form>
                                            </div>





                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
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