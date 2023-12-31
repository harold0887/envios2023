<div class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card-body" style="padding: 5px !important;">

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
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width:{{$porcentaje}}%" aria-valuemax="{{$maxProducts}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end"> {{ number_format( $product->vTotal,2)}} </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    <tr class="font-weight-bold">
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
                                                    <div class="progress">
                                                        <div class="progress-bar bg-ligth" style="width:{{$porcentaje}}%" aria-valuemax="{{$maxPackages}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end "> {{ number_format( $product->vTotal,2)}} </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    <tr class="font-weight-bold">
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
                                                <div class="col">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width:{{$porcentaje}}%" aria-valuemax="{{$maxMemberships}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end "> {{ number_format( $product->vTotal,2)}} </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td>Suma de ventas de membresias</td>
                                        <td></td>
                                        <td class="text-end font-weight-bold">{{ number_format( $sumMemberships,2)}} </td>
                                    </tr>

                                    <tr class="font-weight-bold" style="border-top:solid 2px aqua">
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



        <div class="row">











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