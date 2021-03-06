@extends('layouts.app', ['current' => 'tabela_precos'])

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
            <li class="breadcrumb-item"><a href="/vagas/subcategorias">Gerenciamento de Subcategorias de Vagas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Subcategoria</li>
        </ol>

        <h4 id="section4" class="mg-b-10">Nova Subcategoria</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/vagas/nova_subcategoria">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="categoria">Categoria</label>
                        <select class="custom-select" name="vaga_id">
                            @foreach($vagasArray as $vaga)
                            <option value="{{$vaga['id']}}">{{$vaga['nome']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">

                        <label for="viariavel">Subcategoria</label>
                        <input id="subcategoria_nome" type="text" class="form-control @error('subcategoria_nome') is-invalid @enderror" name="subcategoria_nome" value="{{ old('subcategoria_nome') }}" 
                        required autocomplete="subcategoria_nome">

                        @error('subcategoria_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="valor">Valor da Licença</label>
                        <input id="valor" type="text" class="form-control @error('valor') is-invalid @enderror moeda" name="valor">

                        @error('valor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">{{ __('Cadastrar Subcategoria') }}</button>
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

        /*$(".valores").maskMoney();

        $("#valorMinimo").change(function() {
            var valorMinimo = $("#valorMinimo").val();
            valorMinimo     = parseFloat(valorMinimo, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1").toString();
            var valorMedio  = valorMinimo * 1.18;
            var valorMaximo = valorMedio * 1.40;

            $("#valorMedio").val(parseFloat(valorMedio, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1").toString());
            $("#valorMaximo").val(parseFloat(valorMaximo, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1").toString());
        });*/
    });
</script>

@endsection