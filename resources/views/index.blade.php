@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/dashforge.auth.css')}}">
@endsection

@section('body')
<div class="content content-fixed content-auth">
    <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
            <div class="media-body align-items-center d-none d-lg-flex">
                <div class="mx-wd-600">
                    <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="">
                </div>

            </div><!-- media-body -->
            <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                <div class="wd-100p">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h3 class="tx-color-01 mg-b-5">Acessar</h3>
                        <p class="tx-color-03 tx-16 mg-b-40">Bem-vindo de volta! Por favor, entre com as informações
                            para continuar.</p>

                        <div class="form-group">
                            <label>Endereço Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mg-b-5">
                                <label class="mg-b-0-f">Senha</label>
                                <a href="" class="tx-13">Esqueceu sua senha?</a>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button class="btn btn-brand-02 btn-block">Acessar</button>
                    </form>
                </div>
            </div><!-- sign-wrapper -->
        </div><!-- media -->
    </div><!-- container -->
</div><!-- content -->
@endsection


@section('js')
<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

<script src="{{asset('js/dashforge.js')}}"></script>

<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>
@endsection