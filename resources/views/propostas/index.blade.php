@extends('layouts.app', ["current" => "propostas"])


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
            <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
            <li class="breadcrumb-item active" aria-current="page">Propostas</li>
        </ol>


        @if(session('classe'))
        <div class="alert {{session('classe')}} alert-dismissible fade show" role="alert">
            {{ session('mensagem') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif

        @if(count($propostas) > 0)
        <table id="example1" class="table">
            <thead>
                <tr>
                    <th>#COD</th>
                    <th>Data da Proposta</th>
                    <th>Cliente</th>
                    <th>Projeto</th>
                    <th>Responsável</th>
                    <th>Status da Proposta</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($propostas as $key=>$proposta)
                <tr>
                    <td>#{{++$key}}</td>
                    <td>{!! Helper::formataDataHora($proposta['created_at']) !!}</td>
                    <td>{{$proposta['nomeCliente']}}</td>
                    <td>{!! Helper::retornaPropostaCliente('estabelecimento', $proposta['id']) !!}</td>
                    <td>{!! Helper::retornaPropostaCliente('responsavel', $proposta['id']) !!}</td>
                    <td>
                        @if($proposta['status']==0)
                        <span class="tx-12 tx-danger mg-b-0">Proposta Aguardando Geração.</span>
                        @elseif($proposta['status']==1)
                        <span class="tx-12 tx-success mg-b-0">Proposta Gerada.</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu tx-13">
                                <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">Gerar
                                    Propostas</h6>
                                @if($proposta['status']==0)
                                    <a class="dropdown-item" target="_blank"
                                        href="/propostas/visualizar/{{$proposta['id']}}">Visualizar Full</a>
                                   <!-- <a class="dropdown-item" target="_blank"
                                        href="/propostas/visualizarBasic/{{$proposta['id']}}">Visualizar Basic</a> -->
                                @elseif($proposta['status']==1)
                                    <a class="dropdown-item" target="_blank"
                                    href="/propostas/gerarProposta/{{$proposta['id']}}">Visualizar Proposta</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/propostas/editar/{{$proposta['id']}}">Editar
                                    Proposta</a>
                                <!--<a class="dropdown-item" href="/propostas/delete/{{$proposta['id']}}">Excluir
                                    Proposta</a> -->
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        Nenhuma Proposta Cadastrada.
        @endif
    </div><!-- container -->
</div><!-- content -->
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

        $('#example1').DataTable({

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