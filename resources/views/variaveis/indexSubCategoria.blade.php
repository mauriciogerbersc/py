@extends('layouts.app' , ["current" => "tabela_precos"])


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
            <li class="breadcrumb-item"><a href="./admin">Painel de Controle</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabela de Preços</li>
        </ol>

        <div class="pd-b-30 pd-t-20">
            <div class="dropdown dropright">
                <button class="btn btn-primary dropdown-toggle" type="button" id="droprightMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cadastrar Nova Tabela
                </button>
                <div class="dropdown-menu tx-13" aria-labelledby="droprightMenuButton">
                    <a class="dropdown-item" href="/variaveis/subcategorias/editar/72">Tabela Full</a>
                    <a class="dropdown-item" href="/variaveis/subcategorias/editar/73">Tabela Basic</a>
                </div>
            </div>
        </div>

        @if(session('classe'))
        <div class="alert {{session('classe')}} alert-dismissible fade show" role="alert">
            {{ session('mensagem') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif

        @if(count($arr) > 0)

        <div id="accordion7" class="accordion">
            @foreach($arr as $tab)
            <h6 class="accordion-title">{{$tab->nomeSub}}</h6>
            <div class="accordion-body">
                <table class="table">
                    <thead>

                        <tr>
                            <th>Data criação</th>
                            <th class="dt-center">Tabela de Preços</th>
                            <th class="dt-center">Desconto Aplicado?</th>
                            <th class="dt-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tab->tabela_pai!=0)
                            @foreach(Helper::retornaAnteriores($tab->tabela_pai) as $key=>$a)
                            <tr>
                                <td class="dt-center">{!! Helper::formataDataHora($a['created_at']) !!}</td>       
                                <td class="dt-center"><a href="/variaveis/subcategorias/visualizar/{{$a['id']}}">{{$a['nomeSub']}}</a></td>
                                <td class="dt-center">{{$a['descontoDado']}}%</td>
                                <td class="dt-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" 
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="/variaveis/subcategorias/editar/{{$a['id']}}">Nova apartir desta</a>
                                            <!-- <a class="dropdown-item" href="/variaveis/subcategorias/remover/{{$tab['id']}}">Remover Tabela</a> -->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td class="dt-center">{!! Helper::formataDataHora($tab->created_at) !!}</td>       
                                <td class="dt-center"><a href="/variaveis/subcategorias/visualizar/{{$tab->id}}">{{$tab->nomeSub}}</a></td>
                                <td class="dt-center">{{$tab->descontoDado}}%</td>
                                <td class="dt-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" 
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="/variaveis/subcategorias/editar/{{$tab->id}}">Nova apartir desta</a>
                                            <!-- <a class="dropdown-item" href="/variaveis/subcategorias/remover/{{$tab['id']}}">Remover Tabela</a> -->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
            @endforeach
        </div>

        @endif
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
<script src="{{asset('/lib/jqueryui/jquery-ui.min.js')}}"></script>

<script src="{{asset('js/dashforge.js')}}"></script>
<script>
    $(function() {
        'use strict'

        $('#accordion7').accordion({
            active: false,
            collapsible: true   
          
        });
        

        $('#example1').DataTable({
            pageLength: 50,
            lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "Todos"]],
            responsive: true,
            order: [[0, 'desc']],
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