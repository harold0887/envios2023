<div class="container-fluid  p-0 ">

    <div class="content-main ">


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
                    @for ($i = 2022; $i < 2040; $i++) <option value="{{$i}}"> {{$i}} </option>
                        @endfor
                </select>
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
        <div class="row ">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="submit">

                            <div class="form-row">

                                <div class="form-group col-md-12 mt-5">
                                    <label for="price">Cantidad</label>
                                    <input type="number" class="form-control" name="amount" step="0.01" wire:model.defer="amount">
                                    @error('amount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">

                                    <select class="form-control" name="category" wire:model.defer="category">


                                        <option selected disabled value="">Selecciona una opcion...</option>
                                        @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('category')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 text-center mt-5">
                                <button type="submit" class="btn btn-primary btn-block">Registrar nuevo presupuesto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive rounded table-hover">
                            <table class="table">
                                <thead>
                                    <tr class="table-secondary rounded">
                                        <th><b>Categoria</b></th>
                                        <th><b>Descripcion</b></th>
                                        <th><b>Presupuesto</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category )
                                    @foreach($payments as $payment )

                                    @if($payment->categories_idcategories==$category->id)
                                    @php
                                    $category->totalGastado=$category->totalGastado+$payment->cantidad
                                    @endphp
                                    @endif
                                    @endforeach
                                    @foreach($presupuestoCategorias as $item )
                                    @if($item->categories_id==$category->id)
                                    @php
                                    $category->totalPresupuesto=$category->totalPresupuesto+$item->cantidad
                                    @endphp
                                    @endif
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td class="text-start" style="padding:0px !important">
                                            <a class="nav-link text-dark cursor-default ">
                                                <i class="material-icons">{{$category->icon}}</i>
                                                {{$category->name}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$category->description}}
                                        </td>

                                        <td class="text-end">{{ number_format( $category->totalPresupuesto,2)}} </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="padding:0px !important">
                                            <a class="nav-link text-dark cursor-default ">
                                                <i class="material-icons">density_small</i>
                                                Total
                                            </a>
                                        </td>
                                        <td></td>
                                        <td class="text-end">{{number_format($sumPresupuesto[0]->Total,2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        




    </div>


</div>