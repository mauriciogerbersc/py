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
            <li class="breadcrumb-item"><a href="/variaveis">Variáveis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Variável</li>
        </ol>


        <h4 id="section4" class="mg-b-10">Nova Variável</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/variaveis/nova">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="categoria">Categoria</label>
                        <select class="custom-select" name="categoria_id">
                            @foreach($cats as $cat)
                            <option value="{{$cat['id']}}">{{$cat['nome']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">

                        <label for="viariavel">Nome Variável</label>
                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" 
                        required autocomplete="nome">

                        @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="valorMinimo">Valor Mínimo</label>
                        <input id="valorMinimo" type="text" class="form-control @error('valorMinimo') is-invalid @enderror valores" name="valorMinimo" data-thousands=""  data-decimal="." autocomplete="valorMinimo">

                        @error('valorMinimo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="valorMedio">Valor Médio</label>
                        <input id="valorMedio" type="text" class="form-control @error('valorMedio') is-invalid @enderror valores" name="valorMedio" data-thousands=""  data-decimal="." required value="0.00" >

                        @error('valorMedio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="valorMaximo">Valor Máximo</label>
                        <input id="valorMaximo" type="text" class="form-control @error('valorMaximo') is-invalid @enderror valores" name="valorMaximo" data-thousands=""  data-decimal="." required autocomplete="valorMaximo">

                        @error('valorMaximo')
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
<script src="{{asset('lib/jquery.maskMoney/jquery.maskMoney.js')}}" type="text/javascript"></script>
<script>
    $(function() {
        'use strict'

        $(".valores").maskMoney();

        $("#valorMinimo").change(function() {
            var valorMinimo = $("#valorMinimo").val();
            valorMinimo     = parseFloat(valorMinimo, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1").toString();
            var valorMedio  = valorMinimo * 1.18;
            var valorMaximo = valorMedio * 1.40;

            $("#valorMedio").val(parseFloat(valorMedio, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1").toString());
            $("#valorMaximo").val(parseFloat(valorMaximo, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1").toString());
        });
    });
</script>

@endsection