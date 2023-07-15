<div class="content">
  <div class="content">
    <div class="container-fluid">
      <!-- <div class="row">
            <div class="col-12">
                @foreach($products as $product)

                <span>{{$product->title}}</span>
                {{$product->ventas}}
                <br>

                @endforeach
            </div>
        </div> -->
      <div class="row">

        <div class="col-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">receipt</i>
              </div>
              <div class="row">
                <div class="col-12 col-md-6 px-0">
                  <h4 class="card-title font-weight-bold">Ventas.</h4>
                </div>
              </div>
            </div>
            <div class="card-body row">
              <div class="col-12">
                @if ($search != '')
                <div class="d-flex mt-2">
                  <span class="text-base">Borrar filtros </span>
                  <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearSearch()">close</i>
                </div>
                @endif
              </div>
              <div class="col-10 col-md-8 pr-0">
                <form class="form-group">
                  <div class="input-group rounded">
                    <input id="input-search" type="search" class="form-control px-3" placeholder="Buscar por orden, email, etc..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                  </div>
                </form>
              </div>
              <div class="col-2 col-lg-1 p-0">
                <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                  <i class="material-icons " style="color:#c09aed">search</i>
                </button>
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
        <!-- <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons"></i>
              </div>
              <h4 class="card-title">Global Sales by Top Locations</h4>
            </div>
            <div class="card-body ">
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive table-sales">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="{{ asset('material')}}/img/flags/US.png">
                            </div>
                          </td>
                          <td>USA</td>
                          <td class="text-right">
                            2.920
                          </td>
                          <td class="text-right">
                            53.23%
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="{{ asset('material')}}/img/flags/DE.png">
                            </div>
                          </td>
                          <td>Germany</td>
                          <td class="text-right">
                            1.300
                          </td>
                          <td class="text-right">
                            20.43%
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="{{ asset('material')}}/img/flags/AU.png">
                            </div>
                          </td>
                          <td>Australia</td>
                          <td class="text-right">
                            760
                          </td>
                          <td class="text-right">
                            10.35%
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="{{ asset('material')}}/img/flags/GB.png">
                            </div>
                          </td>
                          <td>United Kingdom</td>
                          <td class="text-right">
                            690
                          </td>
                          <td class="text-right">
                            7.87%
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="{{ asset('material')}}/img/flags/RO.png">
                            </div>
                          </td>
                          <td>Romania</td>
                          <td class="text-right">
                            600
                          </td>
                          <td class="text-right">
                            5.94%
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="{{ asset('material')}}/img/flags/BR.png">
                            </div>
                          </td>
                          <td>Brasil</td>
                          <td class="text-right">
                            550
                          </td>
                          <td class="text-right">
                            4.34%
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-6 ml-auto mr-auto">
                  <div id="worldMap" style="height: 300px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
      <!-- <button type="button" class="btn btn-round btn-default dropdown-toggle btn-link" data-toggle="dropdown">
  7 days
  </button> -->



      <!-- <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-rose" data-header-animation="true">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <div class="card-actions">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                  <i class="material-icons">refresh</i>
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                  <i class="material-icons">edit</i>
                </button>
              </div>
              <h4 class="card-title">Website Views</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success" data-header-animation="true">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <div class="card-actions">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                  <i class="material-icons">refresh</i>
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                  <i class="material-icons">edit</i>
                </button>
              </div>
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.
              </p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-info" data-header-animation="true">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <div class="card-actions">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                  <i class="material-icons">refresh</i>
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                  <i class="material-icons">edit</i>
                </button>
              </div>
              <h4 class="card-title">Completed Tasks</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
      </div> -->



      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">

                <i class="material-icons">equalizer</i>
              </div>
              <p class="card-category">Ventas del día</p>
              <h3 class="card-title"> ${{$salesDay}} </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons text-danger">warning</i>
                <a href="#pablo">Get More Space...</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
              <i class="fa-solid fa-chart-pie"></i>
              </div>
              <p class="card-category">Ventas del mes</p>
              <h3 class="card-title">${{$salesMonth}} </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Tracked from Google Analytics
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="fa-sharp fa-solid fa-calendar-days"></i>
              </div>
              <p class="card-category">Ventas del año</p>
              <h3 class="card-title">$34,245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="fa fa-twitter"></i>
              </div>
              <p class="card-category">Followers</p>
              <h3 class="card-title">+245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
      </div>
      <h3>Manage Listings</h3>
      <br>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="true">
              <a href="#pablo">
                <img class="img" src="{{ asset('material')}}/img/card-2.jpg">
              </a>
            </div>
            <div class="card-body">
              <div class="card-actions text-center">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                  <i class="material-icons">art_track</i>
                </button>
                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                  <i class="material-icons">edit</i>
                </button>
                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                  <i class="material-icons">close</i>
                </button>
              </div>
              <h4 class="card-title">
                <a href="#pablo">Cozy 5 Stars Apartment</a>
              </h4>
              <div class="card-description">
                The place is close to Barceloneta Beach and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the main night life in Barcelona.
              </div>
            </div>
            <div class="card-footer">
              <div class="price">
                <h4>$899/night</h4>
              </div>
              <div class="stats">
                <p class="card-category"><i class="material-icons">place</i> Barcelona, Spain</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="true">
              <a href="#pablo">
                <img class="img" src="{{ asset('material')}}/img/card-3.jpg">
              </a>
            </div>
            <div class="card-body">
              <div class="card-actions text-center">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                  <i class="material-icons">art_track</i>
                </button>
                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                  <i class="material-icons">edit</i>
                </button>
                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                  <i class="material-icons">close</i>
                </button>
              </div>
              <h4 class="card-title">
                <a href="#pablo">Office Studio</a>
              </h4>
              <div class="card-description">
                The place is close to Metro Station and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the night life in London, UK.
              </div>
            </div>
            <div class="card-footer">
              <div class="price">
                <h4>$1.119/night</h4>
              </div>
              <div class="stats">
                <p class="card-category"><i class="material-icons">place</i> London, UK</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-product">
            <div class="card-header card-header-image" data-header-animation="true">
              <a href="#pablo">
                <img class="img" src="{{ asset('material')}}/img/card-1.jpg">
              </a>
            </div>
            <div class="card-body">
              <div class="card-actions text-center">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                  <i class="material-icons">art_track</i>
                </button>
                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                  <i class="material-icons">edit</i>
                </button>
                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                  <i class="material-icons">close</i>
                </button>
              </div>
              <h4 class="card-title">
                <a href="#pablo">Beautiful Castle</a>
              </h4>
              <div class="card-description">
                The place is close to Metro Station and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the main night life in Milan.
              </div>
            </div>
            <div class="card-footer">
              <div class="price">
                <h4>$459/night</h4>
              </div>
              <div class="stats">
                <p class="card-category"><i class="material-icons">place</i> Milan, Italy</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>