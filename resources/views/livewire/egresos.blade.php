<div class="container-fluid  p-0 ">

    <div class="content-main ">
        @include('includes.borders')

        <div class="row mt-3 rounded mx-1 shadow bg-white">
            <div class="col-6 col-md-3">
                <label for="year">Filtrar por mes</label>
                <select class="form-control" name="fop" wire:model="month">
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
            </div>
            <div class="col-6 col-md-3">
                <label for="year">Filtrar por año</label>
                <select class="form-control" name="fop" wire:model="year">
                    <option selected value="">Selecciona el año...</option>
                    @for ($i = 2020; $i < 2040; $i++) <option value="{{$i}}"> {{$i}} </option>
                        @endfor
                </select>
            </div>

            <div class="col-12 col-md-3 d-flex align-items-center">
                <a class="btn btn-primary btn-block" href="{{route('payments.create')}}">
                    <i class="material-icons">add_circle</i>
                    <span>Nuevo gasto</span>
                </a>
            </div>
            @if($year!=date("Y") || $month!=date("m"))
            <div class="col-12 col-md-3  pt-4">
                <div class=" alert alert-light alert-dismissible fade show" role="alert" style="padding: 0 !important;">
                    Borrar filtros
                    <button style="padding: 0 !important;" type="button" class="close" data-dismiss="alert" aria-label="Close" wire:click="clearFilters()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif

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
                            {{number_format($presupuesto[0]->Total,2)}}
                        </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">
                            Presupuesto del mes {{$mesEsp}} del {{$year}}
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
                            {{number_format($egresos[0]->Total,2)}}
                        </h3>
                        </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">

                            @if($presupuesto[0]->Total!=0)
                            <span class="text-danger">
                                <i class="material-icons">arrow_downward</i>
                            </span>
                            {{number_format($egresos[0]->Total*100/$presupuesto[0]->Total)}} % del presupuesto utilizado.
                            @else

                            No ha defnido el presupuesto de {{$mesEsp}} del {{$year}}
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
                            @if($presupuesto[0]->Total-$egresos[0]->Total<=0) 00.00 @else {{ number_format($presupuesto[0]->Total-$egresos[0]->Total,2)}} @endif </h3>
                    </div>
                    <div class="card-footer border-top">
                        <div class="stats">
                            @if($presupuesto[0]->Total-$egresos[0]->Total<=0) No tiene presupuesto disponible @else <span class="text-success">
                                <i class="material-icons">info_outline</i>
                                </span>
                                {{number_format(($presupuesto[0]->Total-$egresos[0]->Total)*100/$presupuesto[0]->Total)}} % del presupuesto disponible.
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(($egresos[0]->Total-$presupuesto[0]->Total) > 0)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">info_outline</i>
                        </div>
                        <p class="card-category text-muted text-end">Exceso</p>
                        <h3 class="card-title h3 text-end">
                            {{number_format($egresos[0]->Total-$presupuesto[0]->Total,2)}}
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


        @include('includes.borders')




    </div>


</div>