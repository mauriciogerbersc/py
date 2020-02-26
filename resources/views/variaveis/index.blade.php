@extends('layouts.app', ["current" => "administrativo"])


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
            <li class="breadcrumb-item"><a href="./dashboard.html">Painel de Controle</a></li>
            <li class="breadcrumb-item active" aria-current="page">Estrutura da Proposta</li>
        </ol>

        <div class="pd-b-30 pd-t-20">
            <a href="/variaveis/nova" class="btn btn-primary">Cadastrar nova Variável</a>
        </div>


        @if(session('classe'))
        <div class="alert {{session('classe')}} alert-dismissible fade show" role="alert">
            {{ session('mensagem') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif


        <div class="table-responsive">

            @foreach($categorias as $categoria)
            <table class="table table-dark table-hover table-striped mg-b-0">
                <thead>
                    <tr>

                        <th class="tx-center">Tipo</th>
                        <th>{{$categoria->nome}}</th>
                        <th>Valor Base</th>
                        <th>Unidade</th>
                        <th class="tx-center">Ordem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variaveis as $var)
                    <tr>
                        @if($categoria->id == $var['categoria_id'])
                        <td style="line-height:3; width:10%" class="tx-center">
                            @if($var['tipo_variavel'] == 0)
                                Full
                            @elseif($var['tipo_variavel'] == 1)
                                Basic
                            @else
                                Ambos
                            @endif
                        </th>
                        <td scope="row" style="line-height:3; width:33%">{{$var['nome']}}</td>
                        <td style="line-height:3; width:15%">
                            R$ {!! Helper::moedaReal($var['valor']) !!}
                        </td>
                        <td style="line-height:3; width:15%">{{$var['unidade']}}</td>
                        <td style="width:15%" class="dt-center">
                            <input type="text" class="form-control ordem" data-variavel="{{$var['id']}}" name="ordem"
                                value="{{$var['ordem']}}" />
                        </td>
                        <td style="line-height:3; width:10%" class="dt-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/variaveis/editar/{{$var['id']}}">Editar Variável</a>
                                    <a class="dropdown-item" href="/variaveis/remover/{{$var['id']}}">Remover
                                        Variável</a>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
          
            @endforeach

        </div>

    </div>
</div>
@endsection



@section('js')
<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('lib/prismjs/prism.js')}}"></script>
<script src="{{asset('lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>

<script src="{{asset('js/dashforge.js')}}"></script>
<script>
    $(function() {
        'use strict'

        $(document).ready(function() {
            
            $(".table").hide();
        
            $("table").has("tbody td").show().after("<hr>");


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $(".ordem").change(function(e){

                e.preventDefault();

                console.log($(this).val());
                console.log($(this).attr("data-variavel"));
                console.log( $('meta[name="_token"]').attr('content'));
                var urlEnviar = '/variaveis/salvaOrdem';
                $.ajax({
                   
                    type: 'POST',
                    url: urlEnviar,
                    data: {
                            'ordem'  : $(this).val(),
                            'variavel': $(this).attr("data-variavel")
                    },
                    success: function(data){
                        if(data.success){
                            alert("Ordem cadastrada com sucesso");
                        }
                    },
                    error: function(){
                        alert('Erro no Ajax !');
                    }
                });
            });
        });
        
        $('#example1').DataTable({
            pageLength: 50,
            lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "Todos"]],
            responsive: true,
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "0": "Nenhuma linha selecionada",
                        "1": "Selecionado 1 linha"
                    }
                }

            }
        });

    });
</script>
@endsection