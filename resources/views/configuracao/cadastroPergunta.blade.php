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
<style>
.hidden {
     display: none;
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
            <li class="breadcrumb-item"><a href="/configuracao/index">Perguntas Cadastradas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Pergunta</li>
        </ol>

        <h4 id="section4" class="mg-b-10">Nova Pergunta</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/configuracao/nova">
                @csrf
                <div class="form-row">


                    <div class="form-group col-md-3">
                        <label for="tipo_proposta">Pertence a que grupo de proposta?</label>
                        <select class="custom-select" name="tipo_proposta">
                            <option value="1">Full</option>
                            <option value="2">Basic</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="categoria">Categoria da Pergunta</label>
                        <select class="custom-select" name="categoria_id">
                            <option value="1">Informações do Estabelecimento</option>
                            <option value="2">Estrutura do Estabelcimento</option>
                            <option value="3">Find Your Car</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="campo_obrigatorio">Campo Obrigatório?</label>
                        <select class="custom-select" name="campo_obrigatorio">
                            <option value="1">Não</option>
                            <option value="2">Sim</option>
                        </select>
                    </div>


                    <div class="form-group col-md-3">
                        <label for="tipo_campo">Tipo de Campo</label>
                        <select class="custom-select tipo_campo" name="tipo_campo">
                            <option value="1">Texto Simples</option>
                            <option value="2">Texto Longo</option>
                            <option value="3">Campo de Seleção</option>
                            <option value="4">Numeral</option>
                        </select>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="pergunta">Pergunta</label>
                        <input id="pergunta" type="text" class="form-control @error('pergunta') is-invalid @enderror" name="pergunta">

                        @error('pergunta')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 opcoes hidden">

                        <table class="table" id="tabelaOpcoes">
                            <tbody id="body">
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="opcao[]" placeholder="Valor da opção. Ex: Sim Ou não.">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger rounded-pill removeRow">x</button>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary rounded-pill add-row">
                            Adicionar Andar/Nível
                        </button>

                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="javascript">Caso seja necessário uso de javascript, informe o ID do campo.</label>
                        <input type="text" class="form-control" name="id_campo"  />
                    </div>

                    <div class="form-group col-md-6">
                        <label for="javascript">Defina o Name da input</label>
                        <input type="text" class="form-control" name="name_campo"  />
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="javascript">HTML apêndice</label>
                        <textarea name="html_apendice" class="form-control" rows="5"></textarea>
                    </div> 
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Cadastrar Pergunta') }}</button>
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


        $(".add-row").click(function() {
            var rows = '';
            rows += '<tr>';
                rows += '<td>';
            rows += ' <input type="text" class="form-control" name="opcao[]" placeholder="Valor da opção. Ex: Sim Ou não.">';
            rows += '</td>';
            rows += '<td>';
            rows += '<button type="button" class="btn btn-danger rounded-pill removeRow">x</button>';
            rows += '</td>';
           
            rows += '</tr>';
            $("#tabelaOpcoes > tbody:last").append(rows);
        });

        $("#tabelaOpcoes").on("click", ".removeRow", function() {
            $(this).closest("tr").remove();
        });

        $(".tipo_campo").change(function(){
            if($(this).val() == 3){
                $('.opcoes').removeClass('hidden');
            }else{
                $('.opcoes').addClass('hidden');
            }
        });
    });
</script>

@endsection