@php
$productUnique=[];
$sumProducts=0;
$sumPackages=0;
$sumMemberships=0;
@endphp


<div class="content p-0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">receipt</i>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <h4 class="card-title font-weight-bold">Registro de Ventas</h4>
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


            @if ($search != '')
            <div class="col-12">
              <small class="text-primary">{{ $orders->count() }} resultados obtenidos</small>
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
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-lg-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">

                  <i class="material-icons">equalizer</i>
                </div>
                <p class="card-category">Ventas del día</p>
                <h3 class="card-title"> ${{ number_format($salesDay,2) }} </h3>
              </div>
              <div class="card-footer p-0">
                <div class="stats">
                  <input class="form-control" type="text" value="" placeholder="" disabled>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                  <i class="fa-solid fa-chart-pie"></i>
                </div>
                <p class="card-category">Ventas del mes de {{$monthSelectName}} {{$yearSelect}}</p>
                <h3 class="card-title">${{ number_format($salesMonth,2) }} </h3>
              </div>
              <div class="card-footer p-0">
                <div class="stats ">
                  <select class="form-control text-muted" wire:model="monthSelect">
                    <option selected value="">Selecciona el mes...</option>
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
                  @if( $monthSelect != now()->format('m') )
                  <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="$set('monthSelect', '{{now()->format('m')}}')">close</i>
                  @endif

                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="fa-sharp fa-solid fa-calendar-days"></i>
                </div>
                <p class="card-category">Ventas del año</p>
                <h3 class="card-title">${{ number_format($salesYear,2) }} </h3>
              </div>
              <div class="card-footer p-0">
                <div class="stats">
                  <select class="form-control" name="fop" wire:model="yearSelect">
                    <option selected value="">Selecciona el año...</option>
                    @for ($i = 2020; $i < 2030; $i++) <option value="{{$i}}"> {{$i}} </option>
                      @endfor
                  </select>

                  @if( $yearSelect != now()->format('Y') )
                  <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="$set('yearSelect', '{{now()->format('Y')}}')">close</i>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                  <i class="fa-solid fa-square-full"></i>
                </div>
                <p class="card-category">Ventas por rango</p>
                <h3 class="card-title">${{ number_format($salesRange,2) }} </h3>
              </div>
              <div class="card-footer p-0">
                <div class="stats">

                  <input class="form-control" type="text" name="datefilter" value="" placeholder="Seleccione rango..." />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons"></i>
            </div>
            <h4 class="card-title">Detalle de ventas por día</h4>
          </div>
          <div class="card-body ">
            <div class="row">
              <div class="col-md-12">

                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>

                        <th><b>Producto</b></th>
                        <th class="text-center"><b>Numero de ventas</b></th>
                        <th class="text-end"><b>Total Vendido</b></th>

                      </tr>
                    </thead>
                    <tbody class="h5 ">
                      @foreach($products as $product)
                      @foreach($productsDay as $item)
                      @php
                      if($product->id == $item->idProduct){
                      $product->numVentas=$product->numVentas+1;
                      $product->vTotal=$product->vTotal+$item->price;
                      $sumProducts=$sumProducts+$item->price;
                      }
                      $porcentaje= $product->numVentas*100/$maxProducts;
                      @endphp
                      @endforeach
                      @if($product->numVentas>0)
                      <tr>
                        <td> {{$product->title}} </td>
                        <td>
                          <div class="row">
                            <div class="col-3 text-end">
                              {{$product->numVentas}}
                            </div>
                            <div class="col">
                              <div class="progress mt-3">
                                <div class="progress-bar bg-success" style="width:{{$porcentaje}}%" aria-valuemax="{{$maxProducts}}"></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-end"> {{ number_format( $product->vTotal,2)}} </td>
                      </tr>
                      @endif
                      @endforeach

                      <tr class="font-weight-bold table-success">
                        <td>Suma de ventas de productos</td>
                        <td></td>
                        <td class="text-end font-weight-bold">{{ number_format( $sumProducts,2)}} </td>
                      </tr>



                      @foreach($packages as $product)
                      @foreach($packagesDay as $item)
                      @php
                      if($product->id == $item->idPackage){
                      $product->numVentas=$product->numVentas+1;
                      $product->vTotal=$product->vTotal+$item->price;
                      $sumPackages=$sumPackages+$item->price;
                      }
                      $porcentaje= $product->numVentas*100/$maxPackages;
                      @endphp
                      @endforeach
                      @if($product->numVentas>0)
                      <tr>
                        <td> {{$product->title}} </td>
                        <td>
                          <div class="row">
                            <div class="col-3 text-end">
                              {{$product->numVentas}}
                            </div>
                            <div class="col">
                              <div class="progress mt-3">
                                <div class="progress-bar bg-ligth" style="width:{{$porcentaje}}%" aria-valuemax="{{$maxPackages}}"></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-end "> {{ number_format( $product->vTotal,2)}} </td>
                      </tr>
                      @endif
                      @endforeach
                      <tr class="font-weight-bold table-success">
                        <td>Suma de ventas de paquetes</td>
                        <td></td>
                        <td class="text-end ">{{ number_format( $sumPackages,2)}} </td>
                      </tr>
                      @foreach($memberships as $product)
                      @foreach($membershipsDay as $item)
                      @php
                      if($product->id == $item->idMembership){
                      $product->numVentas=$product->numVentas+1;
                      $product->vTotal=$product->vTotal+$item->price;
                      $sumMemberships=$sumMemberships+$item->price;
                      }
                      $porcentaje= $product->numVentas*100/$maxMemberships;
                      @endphp
                      @endforeach
                      @if($product->numVentas>0)
                      <tr>
                        <td> {{$product->title}} </td>
                        <td>
                          <div class="row">
                            <div class="col-3 text-end">
                              {{$product->numVentas}}
                            </div>
                            <div class="col ">
                              <div class="progress mt-3">
                                <div class="progress-bar bg-warning" style="width:{{$porcentaje}}%" aria-valuemax="{{$maxMemberships}}"></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-end "> {{ number_format( $product->vTotal,2)}} </td>
                      </tr>
                      @endif
                      @endforeach
                      <tr class="font-weight-bold table-success">
                        <td>Suma de ventas de membresias</td>
                        <td></td>
                        <td class="text-end font-weight-bold">{{ number_format( $sumMemberships,2)}} </td>
                      </tr>

                      <tr class="font-weight-bold text-success" style="border-top:solid 2px">
                        <td>Total de ventas</td>
                        <td></td>
                        <td class="text-end ">{{ number_format( $sumMemberships+$sumPackages+$sumProducts,2)}} </td>
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
      </div>
      <div class="col-12 col-lg-6">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">trending_up</i>
                </div>
                <h4 class="card-title">Global Sales Top 10s </h4>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive table-sales">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">
                              Imagen
                            </th>
                            <th class="font-weight-bold">
                              Titulo
                            </th>
                            <th class="font-weight-bold">
                              Ventas
                            </th>
                            <th class="font-weight-bold">
                              Suma ventas
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          @if( isset($topProducts) && $topProducts != null )

                          @foreach($topProducts as $product)
                          <tr>
                            <td class=" py-1">

                              <img src="{{ Storage::url($product->itemMain) }} " width="60">

                            </td>
                            <td>
                              {{$product->title}}
                            </td>
                            <td>
                              {{$product->sales_count}}
                            </td>
                            <td>
                              {{ number_format( $product->sales_sum_price,2)}}
                            </td>
                          </tr>

                          @endforeach

                          @endif



                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>




    </div>






    




  </div>











  @push('js')

  <!--  Data picker select range    -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <!-- End Data picker select range    -->


  <script type="text/javascript">
    $(function() {

      $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
          cancelLabel: 'Clear'
        }
      });

      $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        Livewire.emit('rangeSelect', picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'), picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'))
      });

      $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        Livewire.emit('rangeClear')
      });
    });
  </script>


  @endpush














</div>