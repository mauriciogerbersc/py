@extends('layouts.app')

@section('vendor')
<!-- vendor css -->
<link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/typicons.font/typicons.css')}}" rel="stylesheet">
<link href="{{asset('lib/prismjs/themes/prism-vs.css')}}" rel="stylesheet">
@endsection

@section('css')
<!-- DashForge CSS -->
<link rel="stylesheet" href="{{asset('css/dashforge.demo.css')}}">
@endsection


@section('header')
x
@endsection

@section('body')
<div class="content content-fixed">
    <div class="container">
        <ol class="breadcrumb df-breadcrumbs mg-b-10">
            <li class="breadcrumb-item"><a href="/dashboard">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="/variaveis/categorias/">Categorias de Variaveis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Categoria</li>
        </ol>


        <h4 id="section4" class="mg-b-10">Nova Categoria</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/variaveis/categorias/nova">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="categoria">Categoria</label>
                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="Nome" autofocus>

                        @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
             
                <button type="submit" class="btn btn-primary">{{ __('Cadastrar Categoria') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection