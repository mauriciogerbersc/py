@extends('layouts.app')

@section('vendor')
<!-- vendor css -->
<link href="{{asset('lib/typicons.font/typicons.css')}}" rel="stylesheet">
<link href="{{asset('lib/prismjs/themes/prism-vs.css')}}" rel="stylesheet">
<link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/dashforge.profile.css')}}">
@endsection

@section('header')
x
@endsection

@section('body')



<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">

        <ol class="breadcrumb df-breadcrumbs mg-b-10">
            <li class="breadcrumb-item"><a href="/dashboard">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="/propostas">Proposta</a></li>
        </ol>

        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <h4 class="mg-b-5">Proposta #{{$proposta->id}}</h4>
                <p class="mg-b-0 tx-color-03">{{$proposta->created_at}}</p>
            </div>
            <div class="mg-t-20 mg-sm-t-0">
                <button class="btn btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer mg-r-5">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg> Imprimir</button>
                <button class="btn btn-white mg-l-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mg-r-5">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg> Enviar por E-mail</button>
                <button class="btn btn-primary mg-l-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mg-r-5">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg> Gerar Contrato</button>
            </div>
        </div>
    </div>
    <div class="content tx-13">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="row">
                <div class="col-sm-6">

                    <h6 class="tx-15 mg-b-10">{{$proposta->estabelecimento}}</h6>
                    <p class="mg-b-0">Responsável: {{$proposta->responsavel}}</p>
                    <p class="mg-b-0">Email: youremail@companyname.com</p>
                </div><!-- col -->
                <div class="col-sm-6 tx-right d-none d-md-block">
                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Proposta número</label>
                    <h1 class="tx-normal tx-color-04 mg-b-10 tx-spacing--2">#{{$proposta->id}}</h1>
                </div><!-- col -->
            </div><!-- row -->

            <div class="table-responsive mg-t-40">
                <table class="table table-invoice bd-b">

                    <thead>
                        <tr>
                            <th class="wd-40p">1.1 - PARKEYES FULL - SOFTWARE</th>
                            <th class="wd-20p">Preços</th>
                            <th class="tx-center">Quantidades</th>
                            <th class="tx-right">Projeto</th>
                        </tr>
                    </thead>


                    <tbody>
                        <tr>
                            <td class="tx-nowrap">VAGAS - licenças por vaga</td>
                            <td class="tx-nowrap"><input type="text" class="form-control" value="{{$valorPorLicenca}}" /></td>
                            <td class="tx-center"><input type="text" class="form-control" value="{{$totalDeVagas}}" /></td>
                            <td class="tx-right"><input  type="text"  class="form-control"  value="{{$valorPorLicenca*$totalDeVagas}}" /></td>
                        </tr>
                        <tr>
                            <td class="tx-nowrap">Câmeras - licenças por câmera IP extra</td>
                            <td class="tx-nowrap"><input type="text" class="form-control" value="{{$valorPorLicenca}}" /></td>
                            <td class="tx-center"><input type="text" class="form-control" value="" /></td>
                            <td class="tx-right"><input type="text" class="form-control" value="" /></td>
                        </tr>
                        <tr>
                            <td class="tx-nowrap">Licenças por TB de gravação</td>
                            <td class="tx-nowrap"><input type="text" class="form-control" value="" /></td>
                            <td class="tx-center"><input type="text" class="form-control" value="" /></td>
                            <td class="tx-right"><input type="text" class="form-control" value="" /></td>
                        </tr>
                    </tbody>


                </table>


                <table class="table table-invoice bd-b" id="tabelaConta" onLoad="somarTabela();">

                    <thead>
                        <tr>
                            <th class="wd-40p">1.2 - PARKEYES FULL - HARDWARE PRINCIPAL</th>
                            <th class="wd-20p">Preços</th>
                            <th class="tx-center">Quantidades</th>
                            <th class="tx-right">Projeto</th>
                        </tr>
                    </thead>

                    

                    <tbody>
                        <tr>
                            <td class="tx-nowrap">ARMAZENAMENTO EXTRA / 1000 GB</td>
                            <td class="tx-nowrap"><input type="text" class="form-control valor1" value="{{$armazenamentoExtra}}" /> </td>
                            <td class="tx-center"><input type="text" class="form-control valor2" value="{{($totalDeVagas*$proposta['qtdDiasDeGravacao']*4/1000)}}" /></td>
                            <td class="tx-right"> <input type="text" class="form-control total"  value="{{$armazenamentoExtra*($totalDeVagas*$proposta['qtdDiasDeGravacao']*4/1000)}}" /> </td>
                        </tr>
                        <tr>
                            <td class="tx-nowrap">CÂMERAS PARKEYES FULL</td>
                            <td class="tx-nowrap"><input type="text" class="form-control" value="{{$camerasParkEyesFull}}" /></td>
                            <td class="tx-center"><input type="text" class="form-control" value="{{($totalDeVagas*0.52)}}" /></td>
                            <td class="tx-right"><input type="text" class="form-control" value="{{$camerasParkEyesFull*($totalDeVagas*0.52)}}"></td>
                        </tr>
                        <tr>
                            <td class="tx-nowrap">CÂMERAS CFTV PARKEYES FULL</td>
                            <td><input type="text" class="form-control" value="{{$camerasParkEyesFull}}" /></td>
                            <td class="tx-center"></td>
                            <td class="tx-right"><input type="text" class="form-control" value="" /></td>
                        </tr>
                        <tr>
                            <td>CÂMERAS LPR PARA CANCELA </td>
                            <td>R$ 7,500.00</td>
                            <td class="tx-center"> </td>
                            <td class="tx-right">R$ - </td>
                        </tr>
                        <tr>
                            <td>PAINÉIS INTERNOS PE.PMI.D8</td>
                            <td>R$ 1,068.00</td>
                            <td class="tx-center">20 un. </td>
                            <td class="tx-right">R$ 21,360.00 </td>
                        </tr>
                        <tr>
                            <td>PAINEL EXTERNO - preço por linha</td>
                            <td>R$ 1,068.00 </td>
                            <td class="tx-center">6 un. </td>
                            <td class="tx-right"> R$ 6,408.00 </td>
                        </tr>
                        <tr>
                            <td>Totem "Find Your Car" </td>
                            <td>R$ 12,000.00 </td>
                            <td class="tx-center">2 un. </td>
                            <td class="tx-right">R$ 24,000.00 </td>
                        </tr>
                        <tr>
                            <td>CAIXA PRINCIPAL DE DISTRIBUIÇÃO CISCO </td>
                            <td>R$ 1,920.00 </td>
                            <td class="tx-center">2 un. </td>
                            <td class="tx-right">R$ 3,840.00 </td>
                        </tr>
                        <tr>
                            <td>CAIXA DE DISTRIBUIÇÃO SECUNDÁRIA CISCO</td>
                            <td>R$ 1,700.00 </td>
                            <td class="tx-center">41 un. </td>
                            <td class="tx-right">R$ 69,700.00</td>
                        </tr>
                        <tr>
                            <td>CAIXA AC-DC-48VDC</td>
                            <td>R$ 2,280.00 </td>
                            <td class="tx-center">2 un. </td>
                            <td class="tx-right">R$ 4,560.00 </td>
                        </tr>
                        <tr>
                            <td>CAIXA ADAM - RELÉ </td>
                            <td>R$ 1,680.00 </td>
                            <td class="tx-center">2 un. </td>
                            <td class="tx-right">R$ 3,360.00</td>
                        </tr>
                        <tr>
                            <td>SERVIDOR</td>
                            <td>R$ 11,880.00 </td>
                            <td class="tx-center">1 un. </td>
                            <td class="tx-right">R$ 11,880.00 </td>
                        </tr>
                        <tr>
                            <td>CABO RJ45 - 3M </td>
                            <td>R$ 3.60 </td>
                            <td class="tx-center">126 un. </td>
                            <td class="tx-right">R$ 453.60 </td>
                        </tr>
                        <tr>
                            <td>CABO RJ45 - 6M</td>
                            <td>R$ 6.00 </td>
                            <td class="tx-center">105 un.</td>
                            <td class="tx-right">R$ 630.00 </td>
                        </tr>
                        <tr>
                            <td>CABO RJ45 - 9M </td>
                            <td>R$ 10.20 </td>
                            <td class="tx-center">273 un.</td>
                            <td class="tx-right"> R$ 2,784.60 </td>
                        </tr>
                        <tr>
                            <td>CABO RJ45 - 25M </td>
                            <td>R$ 21.60 </td>
                            <td class="tx-center">42 un. </td>
                            <td class="tx-right">R$ 907.20</td>
                        </tr>
                        <tr>
                            <td>CABO RJ45 - 35M </td>
                            <td>R$ 30.00 </td>
                            <td class="tx-center">14 un. </td>
                            <td class="tx-right">R$ 420.00 </td>
                        </tr>
                        <tr>
                            <td>CABO RJ45 - 50M </td>
                            <td>R$ 48.00</td>
                            <td class="tx-center">3 un. </td>
                            <td class="tx-right">R$ 144.00 </td>
                        </tr>
                        <tr>
                            <td>Coupler RJ 45</td>
                            <td>R$ 3.00 </td>
                            <td class="tx-center">154 un. </td>
                            <td class="tx-right">R$ 462.00</td>
                        </tr>
                        <tr>
                            <td>Cabo bifilar de baixa tensão 2X1,5mm </td>
                            <td>R$ 2.28 </td>
                            <td class="tx-center">1260 metros </td>
                            <td class="tx-right">R$ 2,872.80 </td>
                        </tr>
                        <tr>
                            <td>Cabo bifilar de baixa tensão 3X1,5mm </td>
                            <td>R$ 2.76 </td>
                            <td class="tx-center">560 metros</td>
                            <td class="tx-right">R$ 1,545.60 </td>
                        </tr>
                        <tr>
                            <td>Cabo para rede LAN Ethernet UTP Cat5e LSZH </td>
                            <td>R$ 1.56 </td>
                            <td class="tx-center">1050 metros </td>
                            <td class="tx-right">R$ 1,638.00</td>
                        </tr>

                    </tbody>


                </table>
            </div>

            <div class="row justify-content-between">
                <div class="col-sm-6 col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0">
                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Notes</label>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
                </div><!-- col -->
                <div class="col-sm-6 col-lg-4 order-1 order-sm-0">
                    <ul class="list-unstyled lh-7 pd-r-10">
                        <li class="d-flex justify-content-between">
                            <span>Sub-Total</span>
                            <span>$5,750.00</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Tax (5%)</span>
                            <span>$287.50</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Discount</span>
                            <span>-$50.00</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <strong>Total Due</strong>
                            <strong>$5,987.50</strong>
                        </li>
                    </ul>

                    <button class="btn btn-block btn-primary">Pay Now</button>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div>
</div>
@endsection


@section('js')

<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('js/dashforge.js')}}"></script>

<!-- append theme customizer -->
<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>


<script>

    function somarTabela(){
        var valor1    = $(".valor1").val();
        var valor2    = $(".valor2").val();

        var multiplica    = parseFloat(valor1) * parseFloat(valor2);

        console.log(soma);

        $(".total").val(soma);
    }

</script>

@endsection