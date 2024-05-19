<nav id="{{$navbarClass}}" class="navbar fixed-top sticky-lg-top navbar-expand-lg {{$navbarClass}} navbar-transparent  mb-0" style="background-color: {{$background}} ;  ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand px-0 mx-0" style="padding: 0px !important">

        <a class="navbar-brand py-0" href="{{route('home')}}" style="font-family: 'Fredericka the Great'"><img class="logo-main" src=" {{ asset('./img/logo3.png') }} " alt=""></a>
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">


        @guest

        <li class="nav-item{{ $activePage == 'login' ? ' active' : '' }}">
          <a href="{{ route('login') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">fingerprint</i> {{ __('Login') }}
          </a>
        </li>

        @endguest







        @auth
        <li class="nav-item{{ $activePage == 'home' ? ' active' : '' }}">
          <a href="{{ route('home') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">home</i>Inicio
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
          <a href="{{ route('dashboard') }}" class="nav-link text-primary">
            <i class="material-icons">dashboard</i> dashboard
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'presupuesto' ? ' active' : '' }}">
          <a href="{{ route('presupuesto') }}" class="nav-link text-primary">
            <i class="material-icons">savings</i> Presupuesto
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'movimientos' ? ' active' : '' }}">
          <a href="{{ route('payments.index') }}" class="nav-link text-primary">
            <i class="material-icons">
              monetization_on
            </i> Egresos
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'balance' ? ' active' : '' }}">
          <a href="{{ route('balance') }}" class="nav-link text-primary">
            <i class="material-icons">
              currency_exchange
            </i> Balance
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'membership' ? ' active' : '' }}">
          <a href="{{ route('membresias') }}" class="nav-link text-primary">
            <i class="material-icons">
              card_membership
            </i> Membresias
          </a>
        </li>
       
        
        <li class="nav-item dropdown">
          <a class="nav-link text-primary dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">logout</i>
            @php
            $name = explode(" ", Auth::user()->name);
            echo $name[0];
            @endphp
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background:#e9e9e8;">

            <a class="dropdown-item" href="{{route('profile.edit')}}">{{ __('My Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                      this.closest('form').submit();">Salir</a>
            </form>
          </div>
        </li>
        <li class="nav-item{{ $activePage == 'cart' ? ' active' : '' }}">
          <a href="{{ route('cart.index') }}" class="nav-link text-primary" style="position: relative;">
            <i class="material-icons">shopping_cart</i>Carrito
            <span class="badge rounded-pill badge-notification" style="position: absolute; top:0; left:25px">
              <livewire:cart-count />
            </span>
          </a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>