<div class="container">

    <div class="content-main ">
        <div class="row mt-3 rounded mx-1 shadow bg-white">
            <div class="col-6 col-md-3">
                <label for="year">Filtrar por mes</label>
                <div class="d-flex">
                    <select class="form-control" wire:model.live="filters.month">
                        <option selected value="" disabled>Selecciona el mes...</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">April</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    @if($filters['month'] != now()->format('m'))
                    <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearMonth()">close</i>
                    @endif
                </div>

            </div>
            <div class="col-6 col-md-3">
                <label for="year">Filtrar por año</label>
                <div class="d-flex">
                    <select class="form-control" wire:model.live="filters.year">
                        <option selected value="">Selecciona el año...</option>
                        @for ($i = 2020; $i < 2040; $i++) <option value="{{$i}}"> {{$i}} </option>
                            @endfor
                    </select>
                    @if($filters['year'] != now()->format('Y'))
                    <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearYear()">close</i>
                    @endif
                </div>

            </div>
            <div class="col-6 col-md-3 ">
                <label for="year">Filtrar por categoria</label>
                <div class="d-flex">
                    <select class="form-control d-flex d-flex align-items-center " wire:model.live="filters.category">
                        <option value="">Selecciona una categoria...</option>

                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @if($filters['category'] != '')
                    <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clear()">close</i>
                    @endif
                </div>
            </div>
            <div class="col-6 col-md-3  align-self-center d-flex justify-content-end ">
                <a class="btn btn-primary " href="{{route('payments.create')}}">
                    <div class="d-flex align-items-center">
                        <i class="material-icons mr-2">add_circle</i>
                        <span>Nuevo gasto</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="row justify-content-between pt-3">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">savings</i>
                        </div>
                        <p class="card-category text-muted text-end">Presupuesto</p>
                        <h3 class="card-title h3 text-end">
                            {{number_format($presupuesto,2)}}
                        </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">
                            Presupuesto del mes.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">trending_down</i>
                        </div>
                        <p class="card-category text-muted text-end">Egresos</p>
                        <h3 class="card-title h3 text-end">
                            {{number_format($egresos,2)}}
                        </h3>
                        </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">

                            @if($presupuesto!=0)
                            <span class="text-danger">
                                <i class="material-icons">arrow_downward</i>
                            </span>
                            {{number_format($egresos*100/$presupuesto)}} % del presupuesto utilizado.
                            @else
                            No ha defnido el presupuesto del mes
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_balance</i>
                        </div>
                        <p class="card-category text-muted text-end">Disponible</p>
                        <h3 class="card-title h3 text-end">
                            @if($presupuesto-$egresos<=0) 00.00 @else {{ number_format($presupuesto-$egresos,2)}} @endif </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">
                            @if($presupuesto-$egresos<=0) No tiene presupuesto disponible @else <span class="text-success">
                                <i class="material-icons">info_outline</i>
                                </span>
                                {{number_format(($presupuesto-$egresos)*100/$presupuesto)}} % del presupuesto disponible.
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(($egresos-$presupuesto) > 0)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">info_outline</i>
                        </div>
                        <p class="card-category text-muted text-end">Exceso</p>
                        <h3 class="card-title h3 text-end">
                            {{number_format($egresos-$presupuesto,2)}}
                        </h3>
                        </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">
                            Cantidad excedida del presupuesto
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row shadow">
            @if (isset($gastos) && $gastos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
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
                            <th style="cursor:pointer" wire:click="setSort('cantidad')">
                                @if($sortField=='cantidad')
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
                            <th style="cursor:pointer" wire:click="setSort('concepto')">
                                @if($sortField=='concepto')
                                @if($sortDirection=='asc')
                                <i class="fa-solid fa-arrow-down-a-z"></i>
                                @else
                                <i class="fa-solid fa-arrow-up-z-a"></i>
                                @endif
                                @else
                                <i class="fa-solid fa-sort mr-1"></i>
                                @endif
                                Concepto
                            </th>
                            <th>Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gastos as $gasto)
                        <tr>
                            <td>{{date_format($gasto->created_at, 'd-M-Y g:i A')}}</td>

                            <td>{{ number_format($gasto->cantidad,2) }} </td>
                            <td>{{ $gasto->concepto }} </td>
                            <td>{{ $gasto->category->name }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            @endif
        </div>







    </div>


</div>