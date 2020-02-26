@extends('layouts.app', ["current" => "administrativo"])

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
            <li class="breadcrumb-item"><a href="/variaveis/listar">Estrutura da Proposta</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Variável</li>
        </ol>


        <h4 id="section4" class="mg-b-10">Nova Variável</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/variaveis/nova">
                @csrf
                <div class="form-row">


                    <div class="form-group col-md-4">
                        <label for="categoria">Tipo</label>
                        <select class="custom-select" name="tipo_variavel">
                            <option value="0">
                                Full</option>
                            <option value="1">
                                Basic</option>
                                <option value="2">
                                    Ambos</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="categoria">Categoria</label>
                        <select class="custom-select" name="categoria_id">
                            @foreach($cats as $cat)
                            <option value="{{$cat['id']}}">{{$cat['nome']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">

                        <label for="viariavel">Nome Variável</label>
                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror"
                            name="nome" value="{{ old('nome') }}" required autocomplete="nome">

                        @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="valor">Valor</label>
                        <div class="input-group mg-b-10">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                            </div>
                            <input id="valor" type="text"
                                class="form-control @error('valor') is-invalid @enderror moeda" name="valor" required
                                autocomplete="valor" />
                        </div>
                        @error('valor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">

                        <label for="viariavel">Unidade.</label>

                        <input id="nome" type="text" class="form-control @error('unidade') is-invalid @enderror"
                            name="unidade" value="{{ old('unidade') }}" required autocomplete="unidade">

                        @error('unidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">{{ __('Cadastrar Variável') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection


@section('js')
<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('lib/prismjs/prism.js')}}"></script>

<script src="{{asset('js/dashforge.js')}}"></script>

<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<!--<script src="{{asset('lib/jquery.maskMoney/jquery.maskMoney.js')}}" type="text/javascript"></script>-->
<script>
    $(function() {
        'use strict'

        $(".moeda").mask('000.000.000.000.000,00', {reverse: true});
       // $(".valores").maskMoney();

    });
</script>

@endsection