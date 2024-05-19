<div class="sidebar" data-color="purple" data-background-color="black" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
  <div class="logo">
    <a href="{{route('home')}}" class="simple-text logo-mini">
      MA
    </a>
    <a href="{{route('home')}}" class="simple-text logo-normal">
      MaCa
    </a>
  </div>
  <div class="sidebar-wrapper">
    <div class="user">
      <div class="photo">
        @if (isset(auth()->user()->picture))
        <img src="{{ Storage::url(Auth::user()->picture) }}">
        @else
        <img class="avatar border-gray" src="{{ asset('img/No Profile Picture.png') }}" alt="...">
        @endif
      </div>
      <div class="user-info">
        <a data-toggle="collapse" href="#collapseExample" class="username">
          <span>
          @auth
            {{ auth()->user()->name }}
            @endauth
            <b class="caret"></b>
          </span>
        </a>
        <div class="collapse" id="collapseExample">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> MP </span>
                <span class="sidebar-normal"> My Profile </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span class="sidebar-mini"> S </span>
                <span class="sidebar-normal"> Settings </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="material-icons">dashboard</i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'products' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('products.index') }}">
          <i class="material-icons">view_list</i>
          <p>Productos</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'package' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('package.index') }}">
          <i class="material-icons">library_add</i>
          <p>Paquetes</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'memberships' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('memberships.index') }}">
          <i class="material-icons">card_membership</i>
          <p>Membresias</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'sales' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('sales.index') }}">
          <i class="material-icons">receipt</i>
          <p>Ventas</p>
        </a>
      </li>
     
     





    </ul>
  </div>
</div>