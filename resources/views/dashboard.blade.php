@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{asset('css/dashforge.dashboard.css')}}">
@endsection

@section('header')
x
@endsection

@section('body')

<div class="content content-fixed">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Painel de Controle</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Monitoramento de Propostas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-sm-6 col-lg-4">
                <div class="card card-body">
                    <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Taxa de Conversão
                    </h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h4 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">0.81%</h4>
                        <p class="tx-10 tx-color-03 mg-b-0"><span class="tx-medium tx-success">1.2% <i class="icon ion-md-arrow-up"></i></span> relação com semana anterior</p>
                    </div>

                </div>
            </div><!-- col -->
            <div class="col-sm-6 col-lg-4 mg-t-10 mg-sm-t-0">
                <div class="card card-body">
                    <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Nº de Propostas</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h4 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{$totalDePropostas}}</h4>
                        <p class="tx-10 tx-color-03 mg-b-0"><span class="tx-medium tx-danger">0.7% <i class="icon ion-md-arrow-down"></i></span> relação com semana anterior</p>
                    </div>

                </div>
            </div><!-- col -->

            <div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
                <div class="card card-body">
                    <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Nº de Contratos</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                        <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">250</h3>
                        <p class="tx-10 tx-color-03 mg-b-0">
                            <span class="tx-medium tx-success">2.1% <i class="icon ion-md-arrow-up"></i></span>
                            relação com semana anterior
                        </p>
                    </div>

                </div>
            </div><!-- col -->
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-12">
                <div class="card">
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h6 class="mg-b-5">Propostas x Contratos</h6>
                        <p class="tx-12 tx-color-03 mg-b-0">Número de propostas que viraram contratos.</p>
                    </div><!-- card-header -->
                    <div class="card-body pd-20">
                        <div class="chart-two mg-b-20">
                            <div id="flotChart2" class="flot-chart"></div>
                        </div><!-- chart-two -->

                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
            <div class="col-md-6 col-xl-4 mg-t-10 order-md-1 order-xl-0">
                <div class="card ht-lg-100p">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mg-b-0">Origem das Propostas</h6>
                        <div class="tx-13 d-flex align-items-center">
                            <span class="mg-r-5">País:</span>
                            <a href="" class="d-flex align-items-center link-03 lh-0">Brasil <i class="icon ion-ios-arrow-down mg-l-5"></i></a>
                        </div>
                    </div><!-- card-header -->
                    <div class="card-body pd-0">
                        <div class="pd-y-25 pd-x-20">
                            <div id="vmap" class="ht-200"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless table-dashboard table-dashboard-one">
                                <thead>
                                    <tr>
                                        <th class="wd-40">Estado</th>
                                        <th class="wd-25 text-right">COD da Proposta</th>
                                        <th class="wd-35 text-right">Data de Geração</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tx-medium">São Paulo</td>
                                        <td class="text-right">12201</td>
                                        <td class="text-right">22/10/2019</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-medium">Paraná</td>
                                        <td class="text-right">11950</td>
                                        <td class="text-right">18/10/2019</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-medium">Santa Catarina</td>
                                        <td class="text-right">11198</td>
                                        <td class="text-right">11/10/2019</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->

            <div class="col-md-6 col-xl-4 mg-t-10">
                <div class="card ht-100p">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mg-b-0">Últimas Propostas</h6>
                        <div class="d-flex tx-18">
                            <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                            <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush tx-13">
                        @foreach($propostas as $proposta)
                        <li class="list-group-item d-flex pd-sm-x-20">
                            <a href="/propostas/visualizar/{{$proposta['id']}}">
                                <div class="pd-sm-l-10">
                                    <p class="tx-medium mg-b-0">Proposta #{{$proposta['id']}}</p>
                                    <small class="tx-12 tx-color-03 mg-b-0"> {{$proposta['created_at']}}</small>
                                </div>
                            </a>
                                <div class="mg-l-auto text-right">
                                    <small class="tx-12 tx-success mg-b-0">Finalizada</small>
                                </div>
                            
                        </li>
                        @endforeach
                    </ul>
                    <div class="card-footer text-center tx-13">
                        <a href="/propostas" class="link-03">Ver todas as propostas <i class="icon ion-md-arrow-down mg-l-5"></i></a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>




            <div class="col-md-6 col-xl-4 mg-t-10">
                <div class="card ht-100p">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mg-b-0">Novos Clientes</h6>
                        <div class="d-flex align-items-center tx-18">
                            <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                            <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush tx-13">
                        @foreach($users as $us)
                        <li class="list-group-item d-flex pd-sm-x-20">

                            <div class="pd-l-10">
                                <p class="tx-medium mg-b-0">
                                    <a href="/clientes/editar/{{$us['id']}}">{{$us['name']}}</a>
                                </p>
                                <p class="tx-small">
                                    Nº Propostas: {{$us['total']}}
                                </p>
                            </div>
                            <div class="mg-l-auto d-flex align-self-center">
                                <nav class="nav nav-icon-only">
                                    <a href="" class="nav-link d-none d-sm-block"><i data-feather="mail"></i></a>
                                    <a href="" class="nav-link d-none d-sm-block"><i data-feather="slash"></i></a>
                                    <a href="" class="nav-link d-none d-sm-block"><i data-feather="user"></i></a>
                                    <a href="" class="nav-link d-sm-none"><i data-feather="more-vertical"></i></a>
                                </nav>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="card-footer text-center tx-13">
                        <a href="/clientes" class="link-03">Ver todos os Clientes <i class="icon ion-md-arrow-down mg-l-5"></i></a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>

        </div><!-- row -->
    </div><!-- container -->
</div><!-- content -->


@endsection


@section('js')

<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('lib/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{asset('lib/jquery.flot/jquery.flot.stack.js')}}"></script>
<script src="{{asset('lib/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('lib/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('lib/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('lib/jqvmap/maps/jquery.vmap.brazil.js')}}"></script>

<script src="{{asset('js/dashforge.js')}}"></script>
<script src="{{asset('js/dashforge.sampledata.js')}}"></script>

<!-- append theme customizer -->
<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>

<script>
    $(function() {
        'use strict'
        $.plot('#flotChart2', [{
            data: [
                [0, 55],
                [1, 38],
                [2, 20],
                [3, 70],
                [4, 50],
                [5, 15],
                [6, 30],
                [7, 50],
                [8, 40],
                [9, 55],
                [10, 60],
                [11, 40],
                [12, 32],
                [13, 17],
                [14, 28],
                [15, 36],
                [16, 53],
                [17, 66],
                [18, 58],
                [19, 46]
            ],
            color: '#69b2f8'
        }, {
            data: [
                [0, 80],
                [1, 80],
                [2, 80],
                [3, 80],
                [4, 80],
                [5, 80],
                [6, 80],
                [7, 80],
                [8, 80],
                [9, 80],
                [10, 80],
                [11, 80],
                [12, 80],
                [13, 80],
                [14, 80],
                [15, 80],
                [16, 80],
                [17, 80],
                [18, 80],
                [19, 80]
            ],
            color: '#f0f1f5'
        }], {
            series: {
                stack: 0,
                bars: {
                    show: true,
                    lineWidth: 0,
                    barWidth: .5,
                    fill: 1
                }
            },
            grid: {
                borderWidth: 0,
                borderColor: '#edeff6'
            },
            yaxis: {
                show: false,
                max: 80
            },
            xaxis: {
                ticks: [
                    [0, 'Jan'],
                    [4, 'Feb'],
                    [8, 'Mar'],
                    [12, 'Apr'],
                    [16, 'May'],
                    [19, 'Jun']
                ],
                color: '#fff',
            }
        });


        $('#vmap').vectorMap({
            map: 'brazil_br',
            showTooltip: true,
            backgroundColor: '#fff',
            color: '#d1e6fa',
            selectedRegions: ['Rondônia', 'sp', 'pr', 'FL'],
            selectedColor: '#69b2f8',
            enableZoom: false,
            borderWidth: 1,
            borderColor: '#fff',
            hoverOpacity: .85


        });
        var ctxLabel = ['6am', '10am', '1pm', '4pm', '7pm', '10pm'];
        var ctxData1 = [20, 60, 50, 45, 50, 60];
        var ctxData2 = [10, 40, 30, 40, 55, 25];
    })
</script>
@endsection