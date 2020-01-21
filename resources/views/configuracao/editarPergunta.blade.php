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
            <li class="breadcrumb-item"><a href="/configuracao">Perguntas Cadastradas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Pergunta</li>
        </ol>

        <h4 id="section4" class="mg-b-10">Editar Pergunta</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/configuracao/editar/{{$pergunta->id}}">
                @csrf
                <div class="form-row">


                    <div class="form-group col-md-3">
                        <label for="tipo_proposta">Pertence a que grupo de proposta?</label>
                        <select class="custom-select" name="tipo_proposta">
                            <option value="1" {{ $pergunta->tipo_proposta == 1 ? "selected" : ""}}>Full</option>
                            <option value="2" {{ $pergunta->tipo_proposta == 2 ? "selected" : ""}}>Basic</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="categoria">Categoria da Pergunta</label>
                        <select class="custom-select" name="categoria_id">
                            <option value="1" {{ $pergunta->categoria_id == 1 ? "selected" : ""}}>Informações do Estabelecimento</option>
                            <option value="2" {{ $pergunta->categoria_id == 2 ? "selected" : ""}}>Estrutura do Estabelcimento</option>
                            <option value="3" {{ $pergunta->categoria_id == 3 ? "selected" : ""}}>Find Your Car</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="campo_obrigatorio">Campo Obrigatório?</label>
                        <select class="custom-select" name="campo_obrigatorio">
                            <option value="1" {{ $pergunta->campo_obrigatorio == 1 ? "selected" : ""}}>Não</option>
                            <option value="2" {{ $pergunta->campo_obrigatorio == 2 ? "selected" : ""}}>Sim</option>
                        </select>
                    </div>


                    <div class="form-group col-md-3">
                        <label for="tipo_campo">Tipo de Campo</label>
                        <select class="custom-select" name="tipo_campo">
                            <option value="1" {{ $pergunta->tipo_campo == 1 ? "selected" : ""}}>Texto Simples</option>
                            <option value="2" {{ $pergunta->tipo_campo == 2 ? "selected" : ""}}>Texto Longo</option>
                            <option value="3" {{ $pergunta->tipo_campo == 3 ? "selected" : ""}}>Campo de Seleção</option>
                            <option value="4" {{ $pergunta->tipo_campo == 4 ? "selected" : ""}}>Numeral</option>
                        </select>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="pergunta">Pergunta</label>
                        <input id="pergunta" type="text" class="form-control @error('pergunta') is-invalid @enderror" name="pergunta" value="{{$pergunta->pergunta}}">

                        @error('pergunta')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    
                    <div class="form-group col-md-6">
                        <label for="javascript">Caso seja necessário uso de javascript, informe o ID do campo.</label>
                        <input type="text" class="form-control" name="id_campo" value="{{$pergunta->id_campo}}" />
                    </div>

                    <div class="form-group col-md-6">
                        <label for="javascript">Defina o Name da input</label>
                        <input type="text" class="form-control" name="name_campo" value="{{$pergunta->name_campo}}" />
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="javascript">HTML apêndice</label>
                        <textarea name="html_apendice" class="form-control" rows="5">{{$pergunta->html_apendice}}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Editar Pergunta') }}</button>
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

@endsection