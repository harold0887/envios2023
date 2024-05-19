<div class="container-fluid  p-0 ">

    <div class="content-main ">
 

        <div class="row pt-2 px-2 rounded mx-1 bg-white">
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
        @if($year!='' || $month!='')
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
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">auto_graph</i>
                    </div>
                    <p class="card-category text-muted text-end">Ingresos</p>
                    <h3 class="card-title h3 text-end">
                        {{number_format($ingresos[0]->Total,2)}}
                    </h3>
                </div>
                <div class="card-footer border-top">
                    <div class="stats">
                        Ingresos {{$mesEsp}} {{$year}}
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
                        {{number_format($egresos[0]->Total,2)}}</h3>
                    </h3>
                </div>
                <div class="card-footer border-top">
                    <div class="stats">
                        @if($ingresos[0]->Total==0)
                        -
                        @else
                        <span class="text-danger">
                            <i class="material-icons">arrow_downward</i>
                        </span>
                        {{number_format($egresos[0]->Total*100/$ingresos[0]->Total)}} % del ingreso utilizado.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card shadow">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">account_balance</i>
                    </div>
                    <p class="card-category text-muted text-end">Balance</p>
                    <h3 class="card-title h3 text-end">
                        {{ number_format($ingresos[0]->Total-$egresos[0]->Total,2)}}
                    </h3>
                </div>
                <div class="card-footer border-top">
                    <div class="stats">
                        @if($ingresos[0]->Total==0)
                        -
                        @else
                        <span class="text-info">
                            <i class="material-icons">info_outline</i>
                        </span>
                        {{number_format(($ingresos[0]->Total-$egresos[0]->Total)*100/$ingresos[0]->Total)}} % del ingreso disponible.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    </div>
</div>