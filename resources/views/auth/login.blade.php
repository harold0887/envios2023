@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'login',
'title' => __('Login'),
'pageBackground' => asset("material").'/img/markus-spiske-187777.jpg',
'navbarClass'=>'text-white'
])

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="card card-login card-primary card-hidden mb-3 border border-primary">
                    <div class="card-header card-header-primary text-center  justify-center ">

                        <h4 class="card-title "><strong>Ingresa con tu cuenta</strong></h4>
                    </div>

                    <div class="card-body">
                        <span class="form-group  bmd-form-group email-error {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control err-email" id="exampleEmails" name="email" placeholder="{{ __('Email...') }}" value="{{ old('email', '') }}" required>
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </span>
                        <span class="form-group bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" id="examplePassword" name="password" placeholder="{{ __('Password...') }}" value="" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </span>
                        <div class="form-check mr-auto ml-3 mt-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} aria-checked="true"> {{ __('Remember me') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary  btn-lg" id="btn-login-modal">
                            INGRESAR
                        </button>
                    </div>
                 


                </div>

            </form>
            <div class="row">
                <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-light">
                        <small>{{ __('Forgot password') }} ?</small>
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        md.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    });
</script>
@endpush