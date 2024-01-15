<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">




            <div class="col-12 ">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Productos ({{$products->total()}} registros)</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row ">
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
                                    <a class="btn btn-primary btn-block" href="{{ route('products.create') }}">
                                        <i class="material-icons">add_circle</i>
                                        <span>Nuevo producto</span>
                                    </a>
                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $products->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($products) && $products->count() > 0)
                        <div class="table-responsive ">
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
                                        <th style="cursor:pointer" wire:click="setSort('title')">
                                            @if($sortField=='title')
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
                                        <th style="cursor:pointer" wire:click="setSort('folio')">
                                            @if($sortField=='folio')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Folio
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


                                        <th>Acciones</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr class="{{ $product->percentage > 0 ? 'text-danger' : '' }}">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeFolio({{ $product->id }}, '{{ $product->folio }}')">
                                                <label>
                                                    <input type="checkbox" {{ $product->folio == 1 ? 'checked ' : '' }}>
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $product->price }}</td>



                                        <td>
                                            {{ $product->sales_count }}
                                        </td>


                                        <td>
                                            <div class="togglebutton" wire:change="changeStatus({{ $product->id }}, '{{ $product->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $product->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>


                                        <td class="td-actions">
                                            <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                                <a class="btn btn-success btn-link " href="{{ route('products.edit', $product->id) }}" >
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <form method="post" action="{{ route('products.destroy', $product->id) }} ">
                                                    <input type="text" hidden value="{{$product->title}}">
                                                    <button class=" btn btn-danger btn-link btn-icon btn-sm remove show-alert-delete-product">
                                                        @csrf
                                                        @method('DELETE')
                                                        <i class="material-icons ">close</i>
                                                    </button>
                                                </form>
                                                @if (Storage::exists($product->document))
                                                <a class="btn btn-warning btn-link " wire:click="downloadOriginalDocument({{ $product->id }})" wire:loading.attr="disabled">
                                                    <i class="material-icons" wire:loading.remove wire:target="downloadOriginalDocument">download</i>
                                                    <div class="spinner-border text-warning  spinner-border-sm" role="status" wire:loading.block wire:target="downloadOriginalDocument">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </a>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $products->links() }}
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