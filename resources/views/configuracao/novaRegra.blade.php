@extends('layouts.app', ['current' => 'configuracao'])

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
            <li class="breadcrumb-item"><a href="/configuracao/regras">Regras de Negócio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Pergunta</li>
        </ol>

        <h4 id="section4" class="mg-b-10">Nova Regra</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/configuracao/regras/criar">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="variavel">Variável questionário</label>
                        <select class="custom-select" name="variavel_id">
                            @foreach($variaveis as $variavel)
                                <option value="{{$variavel->id}}">{{$variavel->nome}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pergunta_id">Pergunta do Questionário</label>
                       
                        <select class="custom-select" name="pergunta_id">
                            @foreach($perguntas as $pergunta)
                                <option value="{{$pergunta->id}}">{{$pergunta->pergunta}}</option>
                            @endforeach
                        </select>
                    </div>

                    

                    <div class="form-group col-md-12">
                        <label for="campo_obrigatorio">Defina a regra</label>
                        <textarea name="regra_negocio" rows="5" class="form-control"></textarea>
                    </div>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Cadastrar Regra') }}</button>
                </div>
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


<script>
    $(function() {
        'use strict'


    });
</script>

@endsection