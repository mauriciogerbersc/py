@extends('layouts.app')


@section('vendor')
<!-- vendor css -->
<link href="{{asset('lib/typicons.font/typicons.css')}}" rel="stylesheet">
<link href="{{asset('lib/prismjs/themes/prism-vs.css')}}" rel="stylesheet">
<link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">

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
            <li class="breadcrumb-item"><a href="/provisao/produtos">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Produto</li>
        </ol>

        <h4 id="section4" class="mg-b-10">Editar Produto</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/provisao/editar/{{$provisao->id}}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="categoria">Categoria</label>
                        <select class="custom-select" name="categoria_produto">
                            <option value="0" {{ $provisao->categoriaProduto == 0 ? "selected" : ""}}>Basic</option>
                            <option value="1" {{ $provisao->categoriaProduto == 1 ? "selected" : ""}}>Full</option>
                        </select>
                    </div>
                       
                    <div class="form-group col-md-2">
                        <label for="partnumber">Part Number</label>
                        <input id="partnumber" type="text" class="form-control @error('partnumber') is-invalid @enderror"
                         name="partnumber" value="{{$provisao->part_number}}" autocomplete="partnumber">

                        @error('partnumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group col-md-2">
                        <label for="ncm">NCM</label>
                        <input id="ncm" type="text" class="form-control @error('ncm') is-invalid @enderror"
                         name="ncm" value="{{$provisao->ncm}}" autocomplete="ncm">

                        @error('ncm')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">

                        <label for="produto">Produto</label>
                        <input id="produto" type="text" class="form-control @error('produto') is-invalid @enderror"
                            name="produto" value="{{$provisao->produto}}"  autocomplete="produto">

                        @error('produto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">

                        <label for="preco">Preço</label>
                        <input id="preco" type="text" class="form-control @error('preco') is-invalid @enderror valores"
                        name="preco" value="{{$provisao->preco}}" data-thousands="" data-decimal="." autocomplete="preco">

                        @error('preco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-2">
                        Cálculo Tribuário
                    </div>

                    <div class="form-group col-md-2">
                        <label for="importacao">Aliquota de importação</label>
                        <input id="importacao" type="text" class="form-control @error('importacao') is-invalid @enderror valores"
                            name="importacao" value="{{$provisao->aliquota_imposto_importacao}} "data-thousands="" data-decimal="." autocomplete="importacao">

                        @error('importacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group col-md-2">
                        <label for="ipi">Aliquota de IPI</label>
                        <input id="ipi" type="text" class="form-control @error('ipi') is-invalid @enderror valores"
                            name="ipi" value="{{$provisao->aliquotaIPI}}" data-thousands="" data-decimal="." autocomplete="ipi">

                        @error('ipi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="pis">Aliquota de PIS</label>
                        <input id="pis" type="text" class="form-control @error('pis') is-invalid @enderror valores"
                            name="pis" data-thousands="" value="{{$provisao->aliquotaPIS}}" data-decimal="." autocomplete="pis">

                        @error('pis')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="icms">Aliquota de ICMS</label>
                        <input id="icms" type="text" class="form-control @error('icms') is-invalid @enderror valores"
                            name="icms"  value="{{$provisao->aliquotaICMS}}" data-thousands="" data-decimal="." autocomplete="icms">

                        @error('icms')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="cofins">Aliquota de Cofins</label>
                        <input id="cofins" type="text" class="form-control @error('cofins') is-invalid @enderror valores"
                            name="cofins" value="{{$provisao->aliquotaConfis}}" data-thousands="" data-decimal="." autocomplete="cofins">

                        @error('cofins')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                </div>


                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="descricao">Descrição do Produto</label>

                        <textarea class="form-control @error('descricao') is-invalid @enderror" name="descricao" rows="2" placeholder="Descrição" >{{$provisao->descricao}}</textarea>
                       

                        @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">{{ __('Editar Produto') }}</button>
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

    });
</script>

@endsection