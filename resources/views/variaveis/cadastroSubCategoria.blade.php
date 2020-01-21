@extends('layouts.app', ["current" => "tabela_precos"])

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

<style>
    select[readonly] {
        background: #eee;
        /*Simular campo inativo - Sugestão @GabrielRodrigues*/
        pointer-events: none;
        touch-action: none;
    }
</style>
@endsection


@section('header')
x
@endsection

@section('body')
<div class="content content-fixed">
    <div class="container">
        <ol class="breadcrumb df-breadcrumbs mg-b-10">
            <li class="breadcrumb-item"><a href="/dashboard">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="/variaveis/subcategorias">Tabela de Preços</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Tabela de Preços</li>
        </ol>

        <form method="POST" id="formulario" action="/variaveis/subcategorias/nova">
            <div class="tx-14 mg-b-25">
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="viariavel">Nome da Tabela</label>
                        <input type="text" name="nomeSubGrupo"
                            class="form-control @error('nomeSubGrupo') is-invalid @enderror"
                            placeholder="Nome da Tabela" />


                        @error('nomeSubGrupo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-5 col-form-label">Deseja aplicar um desconto geral no valor
                        base?</label>
                    <div class="col-sm-7 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">%</span>
                        </div>

                        <input id="descontoDado" type="text"
                            class="form-control descontoDado @error('descontoDado') is-invalid @enderror"
                            name="descontoDado" value="0" />

                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="aplicarDesconto">Aplicar</button>
                        </div>

                        @error('descontoDado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @csrf

                <div class="divider-text">Produtos/Variaveis</div>
                @foreach($subs as $sub)

                @foreach($vagas as $key => $vaga)

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">{{$sub['subcategoria_nome']}}</label>
                    </div>

                    <div class="form-group col-md-4">

                        <select class="custom-select" name="intervalo_vagas[]" id="intervalo_vagas" readonly="readonly"
                            tabindex="-1" aria-disabled="true">
                            <option value="1" {{ 1 == $key+1 ? "selected" : ""}}>0 Até 699</option>
                            <option value="2" {{ 2 == $key+1 ? "selected" : ""}}>700 até 999</option>
                            <option value="3" {{ 3 == $key+1 ? "selected" : ""}}>1000 até 1499</option>
                            <option value="4" {{ 4 == $key+1 ? "selected" : ""}}>1500 até 1999</option>
                            <option value="5" {{ 5 == $key+1 ? "selected" : ""}}>2000 até 2499</option>
                            <option value="6" {{ 6 == $key+1 ? "selected" : ""}}>2500 até 2999</option>
                            <option value="7" {{ 7 == $key+1 ? "selected" : ""}}>3000 até 10000</option>
                        </select>

                    </div>

                    <div class="form-group col-md-4">

                        <div class="input-group mg-b-10">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                            </div>

                            <input type="text" class="form-control moeda" name="valor_fixo[][{{$sub['id']}}]"
                                value="{{$sub['valor']}}">
                        </div>
                    </div>

                </div>


                @endforeach
                <hr />
                @endforeach

                <div class="divider-text">Produtos/Fixos</div>


                <div class="table-responsive">

                    @foreach($categorias as $categoria)
                    <table class="table table-light ">
                        <thead>
                            <tr>
                                <th colspan="2" scolpe="col">{{$categoria->nome}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($variaveis as $var)
                            <tr>
                                @if($categoria->id == $var['categoria_id'])
                                <td scope="row" style="line-height:3; width:40%">{{$var['nome']}}</td>
                                <td style="width:59%">
                                    <div class="input-group mg-b-10">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                        </div>
                                        <input id="valor" type="text" class="form-control valoresFixos moeda" name="valor[{{$var['id']}}]" value="{{$var['valorFormatado']}}"
                                        data-valor="{{$var['valor']}}"
                                        >
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach

                </div>
                <button type="submit" class="btn btn-primary">{{ __('Cadastrar Tabela') }}</button>
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
<script src="{{asset('js/jquery.mask.min.js')}}"></script>

<script>
    $(function() {
            'use strict'



            $(".moeda").mask('000.000.000.000.000,00', {reverse: true});
           
            $(".valores").maskMoney();

            $("#aplicarDesconto").click(function() {
                var descontoDado = $("#descontoDado").val();
                
                
                $(".valoresFixos").each(function(index, value) {
                    console.log('input' + index + ':' + $(this).data('valor'));
                
                    //var valor      = $(this).val();
                    var valor         = $(this).data('valor');
                    var descontado    = (parseFloat(valor)*(parseFloat(descontoDado))/100);
                    
                    var valorComDesconto = parseFloat(valor - descontado,10).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.").toString();
                    // seta novo valor 
                  
                    $(this).val(valorComDesconto);
                });

                return false;
            });
        });
</script>
@endsection