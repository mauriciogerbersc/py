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
            <li class="breadcrumb-item"><a href="/dadmin">Painel de Controle</a></li>
            <li class="breadcrumb-item active" aria-current="page">Gerenciamento de Clientes</li>
        </ol>

        <div class="pd-b-30 pd-t-20">
            <a href="/clientes/cadastro" class="btn btn-primary">Novo Cliente</a>
        </div>


        @if(session('classe'))
        <div class="alert {{session('classe')}} alert-dismissible fade show" role="alert">
            {{ session('mensagem') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif

        @if(count($users) > 0)

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Ativos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="excluidos-tab" data-toggle="tab" href="#excluidos" role="tab"
                    aria-controls="excluidos" aria-selected="false">Excluídos</a>
            </li>

        </ul>
        <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h6>Clientes Ativos</h6>

                <table id="example1" class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th class="dt-center">Quantidade de Propostas</th>
                            <th class="dt-center">Tabela de Preços</th>
                            <th class="dt-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key=>$user)
                        @if($user['status'] == 1)
                        <tr>

                            <td class=>{{$user['name']}}</td>
                            <td class="dt-center">{{$user['total']}}</td>
                            <td class="dt-center">
                                <a href="/propostas/{{$user['id']}}" target="_blank">Todos Projetos</a>
                               <!-- <a href="/variaveis/subcategorias/visualizar/{{$user['sub_id']}}" target="_blank">
                                    {{$user['nomeSub']}}
                                </a> -->
                            </td>
                            <td class="dt-center">


                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu tx-13">
                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">
                                            Gerar
                                            Propostas</h6>
                                        <a class="dropdown-item" target="_blank"
                                            href="/propostas/novaBasic/{{$user['id']}}">Projeto Basic</a>
                                        <a class="dropdown-item" target="_blank"
                                            href="/propostas/nova/{{$user['id']}}">Projeto
                                            Full</a>

                                        <div class="dropdown-divider"></div>
                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">
                                            Cliente
                                        </h6>
                                        <a class="dropdown-item" href="/clientes/editar/{{$user['id']}}">Editar
                                            Cliente</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/clientes/status/{{$user['id']}}/0">Excluir
                                            Cliente</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="excluidos" role="tabpanel" aria-labelledby="excluidos-tab">
                <h6>Excluídos</h6>

                <table id="example2" class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th class="dt-center">Quantidade de Propostas</th>
                            <th class="dt-center">Tabela de Preços</th>
                            <th class="dt-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $k=>$user)
                        @if($user['status']==0)
                        <tr>
                            <td class=>{{$user['name']}}</td>
                            <td class="dt-center">{{$user['total']}}</td>
                            <td class="dt-center">
                               <!-- <a href="/variaveis/subcategorias/visualizar/{{$user['sub_id']}}" target="_blank">
                                    {{$user['nomeSub']}}
                                </a>-->

                                <a href="/propostas/{{$user['id']}}" target="_blank">Todos Projetos</a>
                            </td>
                            <td class="dt-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu tx-13">
                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">Gerar Propostas</h6>

                                        <a class="dropdown-item" target="_blank"
                                            href="/propostas/novaBasic/{{$user['id']}}">Projeto Basic</a>
                                        <a class="dropdown-item" target="_blank"
                                            href="/propostas/nova/{{$user['id']}}">Projeto Full</a>
                                        <div class="dropdown-divider"></div>

                                        <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">Cliente </h6>

                                        <a class="dropdown-item" href="/clientes/editar/{{$user['id']}}">Editar Cliente</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/clientes/status/{{$user['id']}}/1">Ativar Cliente</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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

        $('.example1').DataTable({
            columns: [{
                    "width": "10%"
                },
                {
                    "width": "50%"
                },
                {
                    "width": "30%"
                },
                {
                    "width": "20%"
                },
            ],
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

        $('.example2').DataTable({
            columns: [{
                    "width": "10%"
                },
                {
                    "width": "50%"
                },
                {
                    "width": "25%"
                },
                {
                    "width": "15%"
                },
            ],
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