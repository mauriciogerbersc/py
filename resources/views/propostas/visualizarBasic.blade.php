@extends('layouts.app', ["current" => "propostas"])

@section('vendor')
<!-- vendor css -->
<link href="{{asset('lib/typicons.font/typicons.css')}}" rel="stylesheet">
<link href="{{asset('lib/prismjs/themes/prism-vs.css')}}" rel="stylesheet">
<link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<link href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.common-material.min.css" rel="stylesheet">
<link href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.material.min.css" rel="stylesheet">
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/dashforge.profile.css')}}">

<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script> // dependency for Kendo UI API
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>


<style>
    .page-template>* {
        position: absolute;
        left: 20px;
        right: 20px;
        font-size: 90%;
        font-family: 'Montserrat-Regular', sans-serif;
        font-weight: 400;
    }

    .page-template .header {
        top: 20px;
        border-bottom: 0px solid #000;
    }

    .page-template .footer {
        bottom: 20px;
        border-top: 0px solid #000;
    }

    .page-template .watermark {
        font-weight: bold;
        font-size: 400%;
        text-align: right;
        margin-top: 70%;
        color: #aaaaaa;
        opacity: 0.4;
    }
   
    .divider-text {
        font-size: 13px;
        font-weight:800;
    }
</style>
@endsection

@section('header')
x
@endsection

@section('body')

<script type="x/kendo-template" id="page-template">
    <div class="page-template">
           <div class="header">
                <div style="display:block;float:left">
                     <img src="{{asset('img/logo-proposta.png')}}"> 
                </div>
                <div style="display:block;float:right">
                    <img src="{{asset('img/logo-sb-proposta.png')}}"> 
               </div>
           </div>
           <div class="footer" style="text-align: center; margin:0 auto; font-size: 80%">
                <div style="display:block; float:left">
                    <strong>#:pageNum#</strong> de <strong>#:totalPages#</strong>
                </div>
                <div style="width:300px; margin:0 auto; font-size:9px;"">
                    Rua Sebastião Furtado Pereira, 60 - Sala 1109<br>
                    (48) 3372-7030 / (48) 99815-0052 -contato@sbtrade.com.br
                </div>
           </div>
     </div>
</script>

@csrf


<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">

        <ol class="breadcrumb df-breadcrumbs mg-b-10">
            <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="/propostas">Proposta</a></li>
        </ol>

        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <h4 class="mg-b-5">Proposta #{{$proposta['id']}}</h4>
                <p class="mg-b-0 tx-color-03">{!! Helper::formataDataHora($proposta['created_at']) !!}</p>
            </div>
            <div class="mg-t-20 mg-sm-t-0">
                <input type="hidden" value="{{$proposta['id']}}" id="propostaID" />
                <button id="exportarProposta" class="btn btn-primary mg-l-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-credit-card mg-r-5">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg> Gerar Proposta
                </button>
            </div>
        </div>
    </div>

    <div class="content tx-13" id="canvas">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="row">
                <div class="col-sm-6">

                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Responsável</label>


                    <div class="d-flex">
                        <div class="d-flex tx-bold" style="width:120px;">Projeto: </div>
                        <div class="d-flex">{{$proposta['estabelecimento']}}</div>
                    </div>

                    <div class="d-flex">
                        <div class="d-flex tx-bold" style="width:120px;">Responsável: </div>
                        <div class="d-flex">{{$proposta['responsavel']}}</div>
                    </div>


                </div><!-- col -->

                <div class="col-sm-6 tx-right d-none d-md-block">
                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Proposta
                        número</label>
                    <h1 class="tx-normal tx-color-04 mg-b-10 tx-spacing--2">#{{$proposta['id']}}</h1>
                </div><!-- col -->
            </div><!-- row -->
            <br>

            <div class="row pd-t-20">
                <div class="col-sm-12 tx-left d-none d-md-block">
                    <strong>A/C {{$proposta['responsavel']}}</strong><br>
                    Segue proposta de venda e instalação do sistema de gerenciamento de estacionamentos, localização
                    de vagas livres e vigilância por CFTV denominado <strong>ParkEyes Basic</strong>
                </div>
            </div><!-- row -->

            <div class="row pd-t-20">
                <div class="col-sm-12 pd-t-20">
                    <ul class="list-group">
                        <li class="list-group-item">Sistema de Localização de vagas: <strong>Sim</strong></li>
                        <li class="list-group-item">Vídeo Vigilância: <strong>Sim</strong></li>
                        <li class="list-group-item">Vídeo Gravação <strong>{{$totalDiasGravacao}}</strong> dias: Sim</li>
                        <li class="list-group-item">Localize seu carro: <strong>Não</strong></li>
                        <li class="list-group-item">Câmeras IP: <strong>Sim</strong></li>
                        <li class="list-group-item">Alimentação de Câmeras e Painéis Internos com tecnologia POE:
                            <strong>Sim</strong></li>
                    </ul>
                </div>
            </div><!-- row -->


            <hr>
            <div class="card">
                <div class="card-header tx-bold ">
                    Topologia Central
                </div>
                <div class="card-body">
                    A topologia Central permite que até quatro vagas sejam controladas por apenas um módulo
                    gerenciamento,
                    o que minimiza a necessidade de instalação infraestrutura e melhora a estética visual do sistema,
                    uma vez que toda sua fixação se dará em apenas uma calha central.
                </div>
            </div>

            <div class="pd-t-20 wd-600 mg-l-auto mg-r-auto ht-320">
                <div style="margin:0 auto;">
                    <img src="{{asset('img/basic.png')}}" />
                </div>
            </div>

            <div class="page-break"></div>

            <div class="conteudo">

                <div class="table-responsive mg-t-40">
                    <input id="totalDeVagas" type="hidden" value="{{$totalDeVagas}}" />
                    <input id="totalDeVagasInternas" type="hidden" value="{{$vagasInternas}}" />
                    <input id="totalDeVagasExternas" type="hidden" value="{{$vagasDescobertas}}" />
                    <!-- ParkEyes - Software -->
                    @foreach($categoriaSoftware as $categoria)
                    <table id="tbl1" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                        <thead>
                            @php
                                $categoriaNome = str_replace("[[TIPO]]", 'BASIC',$categoria->nome);
                            @endphp
                            <tr>
                                <th class="wd-40p">{{$categoriaNome}}</th>
                                <th class="wd-20p">PREÇOS</th>
                                <th class="tx-center">QUANTIDADES</th>
                                <th class="tx-right">PROJETO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Helper::retornaVariaveis($proposta['cliente_id'], 2, 1, $proposta['id']) as $key=>$val)    
                            <tr>
                                @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta['id'],
                             $vagasInternas) != 0)
                                <td>{{$val['nome']}}</td>
                                <td>
                                    @if($val['preco']==0)
                                    R$ {!! Helper::valorPorVaga($vagasInternas, 'Licenças', $val['sub_fixo_id']); !!}
                                    @else
                                    R$ {!! Helper::moedaReal($val['preco']) !!}
                                    @endif
                                    
                                    @if($val['preco']==0)
                                    <input type="hidden" class="valor"
                                        value="{!! Helper::valorPorVaga($vagasInternas, 'Licenças', $val['sub_fixo_id']); !!}" />
                                    @else
                                    <input type="hidden" class="valor" value="{{ $val['preco'] }}" />
                                    @endif
                                </td>

                                <td class="tx-center">
                                  
                                     {!! Helper::regraDeNegocio($val['regra_de_negocio'], 
                                        $val['variavel_id'],
                                        $proposta['id'], 
                                        $vagasInternas) !!}
    
                                    @if($val['unidade'] !== '')
                                        {{$val['unidade']}}
                                    @endif
    
                                    <input type="hidden" class="quantidade"
                                        value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta['id'], $vagasInternas) !!}" />
                                </td>
    
                                <td class="tx-right total">
                                    <span class="totalSpan"></span>
    
                                    <input type="hidden" class="valorTotal" value="" />
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>

                                <td colspan="2" class="tx-right valorTotalDoGrupo grupo1 tx-size-7"></td>
                            </tr>
                        </tfoot>

                    </table>
                    @endforeach
                            
                     <!-- ParkEyes Hardware Principal -->
                     @foreach($categoriaHardwarePrincipal as $categoria)
                     <table id="tbl2" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                         <thead>
                            @php
                                $categoriaNome = str_replace("[[TIPO]]", 'BASIC',$categoria->nome);
                            @endphp
                            <tr>
                                <th class="wd-40p">{{$categoriaNome}}</th>
                                 <th class="wd-20p">PREÇOS</th>
                                 <th class="tx-center">QUANTIDADES</th>
                                 <th class="tx-right">PROJETO</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach(Helper::retornaVariaveis($proposta['cliente_id'], 4, 1,  $proposta['id']) as $key=>$val)
                             @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta['id'],
                             $vagasInternas) != 0)
                             <tr>
                                <td>{{$val['nome']}}</td>
                                <td>
                                    
                                    @if($val['preco']==0)
                                        @if($val['variavel_id'] == 53 
                                        OR $val['variavel_id'] == 57
                                        OR $val['variavel_id'] == 62
                                        OR $val['variavel_id'] == 63)
                                            @php $var = "Cameras+"; @endphp
                                        @elseif($val['variavel_id'] == 54)
                                            @php $var = "Caixas Secundárias"; @endphp
                                        @else
                                            @php $var = "Licenças"; @endphp
                                        @endif
                                        R$ {!! Helper::valorPorVaga($vagasInternas, $var, $val['sub_fixo_id']); !!}
                                    @else
                                        R$ {!! Helper::moedaReal($val['preco']) !!}
                                    @endif

                                    @if($val['preco']==0)
                                        @if($val['variavel_id'] == 53 
                                        OR $val['variavel_id'] == 57
                                        OR $val['variavel_id'] == 62
                                        OR $val['variavel_id'] == 63)
                                            @php $var = "Cameras+"; @endphp
                                        @elseif($val['variavel_id'] == 54)
                                            @php $var = "Caixas Secundárias"; @endphp
                                        @else
                                            @php $var = "Licenças"; @endphp
                                        @endif
                                        <input type="hidden" class="valor"
                                            value="{!! Helper::valorPorVaga($vagasInternas, $var, $val['sub_fixo_id']); !!}" />
                                        @else
                                            <input type="hidden" class="valor" value="{{$val['preco']}}" />
                                    @endif
                                </td>
                                <td class="tx-center">
                                    {!! Helper::regraDeNegocio($val['regra_de_negocio'], 
                                    $val['variavel_id'],
                                    $proposta['id'], $vagasInternas) !!}
    
                                    <input type="hidden" class="quantidade"
                                        value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], 
                                        $val['variavel_id'], $proposta['id'], $vagasInternas) !!}" />
                                </td>   
                                <td class="tx-right total">
                                    <span class="totalSpan"></span>

                                    <input type="hidden" class="valorTotal" value="" />
                                </td> 
                            </tr>
                             @endif
                             @endforeach
                         </tbody>
                         <tfoot>
                             <tr>
                                 <td></td>
                                 <td></td>
                                 <td colspan="2" class="tx-right valorTotalDoGrupo grupo1 tx-size-7"></td>
                             </tr>
                         </tfoot>
                     </table>
                     @endforeach
 
                     <div class="page-break"></div>
                           
                    <!-- ParkEyes Hardware Nacional -->
                    @foreach($categoriaHardwareNacional as $categoria)
                    <table id="tbl3" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                        <thead>
                            @php
                                $categoriaNome = str_replace("[[TIPO]]", 'BASIC',$categoria->nome);
                            @endphp
                            <tr>
                                <th class="wd-40p">{{$categoriaNome}}</th>
                                <th class="wd-20p">PREÇOS</th>
                                <th class="tx-center">QUANTIDADES</th>
                                <th class="tx-right">PROJETO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Helper::retornaVariaveis($proposta['cliente_id'], 5, 1,  $proposta['id']) as $key=>$val)
                            @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta['id'],
                            $vagasInternas) != 0)
                            <tr>
                                <td>{{$val['nome']}}</td>
                                <td>
                                    @if($val['preco']==0)
                                    R$ {!! Helper::valorPorVaga($vagasInternas, 'nobreak', $val['sub_fixo_id']); !!}
                                    @else
                                    R$ {!! Helper::moedaReal($val['preco']) !!}
                                    @endif


                                    @if($val['preco']==0)
                                    <input type="hidden" class="valor"
                                        value="{!! Helper::valorPorVaga($vagasInternas, 'nobreak', $val['sub_fixo_id']); !!}" />
                                    @else
                                    <input type="hidden" class="valor" value="{{ $val['preco'] }}" />
                                    @endif
                                </td>
                                <td class="tx-center">
                                    {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                    $proposta['id'], $vagasInternas) !!}

                                    <input type="hidden" class="quantidade"
                                        value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta['id'], $vagasInternas) !!}" />

                                </td>
                                <td class="tx-right total">
                                    <span class="totalSpan"></span>

                                    <input type="hidden" class="valorTotal" value="" />
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2" class="tx-right valorTotalDoGrupo grupo1 tx-size-7"></td>
                            </tr>
                        </tfoot>
                    </table>
                    @endforeach

                    <!-- ParkEyes - Instalação completa -->
                    @foreach($categoriaInstalacaoCompleta as $categoria)
                    <table id="tbl4" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                        <thead>
                            @php
                                $categoriaNome = str_replace("[[TIPO]]", 'BASIC',$categoria->nome);
                            @endphp
                            <tr>
                                <th class="wd-40p">{{$categoriaNome}}</th>
                                <th class="wd-20p">PREÇOS</th>
                                <th class="tx-center">QUANTIDADES</th>
                                <th class="tx-right">PROJETO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Helper::retornaVariaveis($proposta['cliente_id'], 6, 1,  $proposta['id']) as $key=>$val)
                            @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta['id'],
                             $vagasInternas) != 0)
                            <tr>
                                <td>{{$val['nome']}}</td>
                                <td>
                                    @if($val['preco']==0)
                                        @if($val['variavel_id'] == 55)
                                            @php $var = "Instalação"; @endphp
                                        @elseif($val['variavel_id'] == 56)
                                            @php $var = "Homologação"; @endphp
                                        @endif
                                            R$ {!! Helper::valorPorVaga($vagasInternas, $var, $val['sub_fixo_id']); !!}
                                        @else
                                            R$ {!! Helper::moedaReal($val['preco']) !!}
                                    @endif
                                   

                                    @if($val['preco']==0)
                                        @if($val['variavel_id'] == 55)
                                            @php $var = "Instalação"; @endphp
                                        @elseif($val['variavel_id'] == 56)
                                            @php $var = "Homologação"; @endphp
                                        @endif
                                        
                                            <input type="hidden" class="valor" value="{!! Helper::valorPorVaga($vagasInternas, $var, $val['sub_fixo_id']); !!}" />    
                                        @else
                                            
                                            <input type="hidden" class="valor" value="{{$val['preco']}}" />
                                    @endif

                                   
                                </td>
                                <td class="tx-center">
                                    {!! Helper::regraDeNegocio($val['regra_de_negocio'],
                                     $val['variavel_id'],
                                    $proposta['id'], $vagasInternas) !!}

                                    <input type="hidden" class="quantidade"
                                        value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], 
                                        $val['variavel_id'], $proposta['id'],
                                         $vagasInternas) !!}" />

                                </td>
                                <td class="tx-right total">
                                    <span class="totalSpan"></span>

                                    <input type="hidden" class="valorTotal" value="" />
                                </td>
                            </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2" class="tx-right valorTotalDoGrupo tx-size-7"></td>
                            </tr>
                        </tfoot>
                    </table>
                    @endforeach

                    
                    <table class="table table-dark table-hover table-striped mg-b-0">
                        <thead>
                            <tr>
                                <th class="wd-40p">TOTAL PARKEYES BASIC</th>
                                <th class="tx-right">PROJETO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sistema ParkEyes:</td>
                                <td class="tx-right" id="totalSistemParkEyes"></td>
                            </tr>
                            <tr>
                                <td>Instalação do Sistema ParkEyes:</td>
                                <td class="tx-right" id="instalacaoSistemaParkEyes"></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td class="tx-right totalSistemaInstalacao"></td>
                            </tr>
                            <tr>
                                <td>Total por Vaga</td>
                                <td class="tx-right totalPorVagaInterna"></td>
                            </tr>
                        </tbody>
                    </table>


                    <table class="table table-dark table-hover table-striped mg-b-0">
                        <thead>
                            <tr>
                                <th class="wd-40p">TOTAL DA PROPOSTA</th>
                                <th class="tx-right">PROJETO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total da proposta:</td>
                                <td class="tx-right totalSistemaInstalacao"></td>
                            </tr>
                            <tr>
                                <td>Total por vaga:</td>
                                <td class="tx-right totalPorVaga"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>



                <div class="card">
                    <div class="card-header tx-bold ">
                        Termo de pagamento
                    </div>
                    <div class="card-body">
                        <p>Referente aos intes 1.1, 1.2, 2.1, 2.2 e 3.1 sinal de 50% no contrato, 20% na entrega do
                            material importado, 30% na entrega do sistema instalado.
                        </p>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Parcela</td>
                                    <td class="text-right" id="primeiraGrupo1"></td>
                                    <td class="text-right" id="segundaGrupo1"></td>
                                    <td class="text-right" id="terceiraGrupo1"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="4" id="totalGrupo1"></td>
                                </tr>
                            </tfoot>
                        </table>

                        <p>
                            Referente aos itens 1.3, 1.4, 2.3 e 2.4 sinal de 50% com quinze dias de antecedência ao
                            início da instalação, 20% no término da instalação das eletrocalhas e 30% na entrega do
                            sistema para configuração.
                        </p>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Parcela</td>
                                    <td class="text-right" id="primeiraGrupo2"></td>
                                    <td class="text-right" id="segundaGrupo2"></td>
                                    <td class="text-right" id="terceiraGrupo2"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="4" id="totalGrupo2"></td>
                                </tr>
                            </tfoot>
                        </table>


                        <p class="tx-bold">
                            Garantia
                        </p>

                        <p>Garantia de dois (2) anos para equipamentos contra defeitos de fabricação e materiais.</p>

                        @php
                            $manutencao_mensal      = Helper::valorPorVaga($vagasInternas, "Manutenção Mensal", $val['sub_fixo_id']);
                            $manutencao_mensalDolar = Helper::moedaDolar($manutencao_mensal);
                            $parcelasMensais        = (($manutencao_mensalDolar*Helper::regraDeNegocio("[[totalDeVagasInternas]]+[[variavel]]", 5, $proposta['id'], $vagasInternas))/12);
                          

                            $parcelasMensais        = Helper::moedaReal($parcelasMensais);
                           
                        @endphp

                        <p class="tx-bold">Exploração de software e manutenção preventiva obrigatória:</p>
                        <ul class="list-group">
                            <li class="list-group-item">Custo anual por Vaga de R$ <strong>{{$manutencao_mensal}}</strong> a serem quitadas 
                                                        em parcelas mensais com total de R$ <strong>{{$parcelasMensais}}</strong>.</li>
                         </ul>	
                       
                    </div>

                </div>

                <hr>
                <div class="page-break"></div>
                <div class="card">
                    <div class="card-header tx-bold ">
                        Incluso
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Suporte técnico telefônico em horário comercial.</li>
                            <li class="list-group-item">Sistema de abertura de chamados online, para chamados de
                                manutenção corretiva.</li>
                            <li class="list-group-item">Atualização de software e suporte remoto.</li>
                            <li class="list-group-item">Uma visita semestral para revisão e ajustes mecânicos, elétricos
                                e eletrônicos de todos os dispositivos do sistema.</li>
                        </ul>
                        <br>
                        <p>* Para integração com tótens de empresas parceiras, é necessário prévia autorização e/ou
                            negociação.</p>
                    </div>
                </div>

                <hr>


                <div class="card">
                    <div class="card-header tx-bold">
                        Cronograma 5 MESES
                    </div>
                    <div class="card-body" style="height:auto;">
                        <div class="wd-520 mg-l-auto mg-r-auto ht-290">
                            <div style="margin:0 auto; width:520px;">
                                <img src="{{asset('img/cronograma.jpeg')}}" />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <ol class="pd-t-20">
                        <li class="ht-70 col-sm">Entende-se por <strong>PAGAMENTO DO SINAL</strong> o fim da fase
                            comercial e de recolhimento
                            de informações do estacionamento para iniciar a entrega e instalação do sistema ParkEyes
                            FULL.</li>

                        <li class="ht-70 col-sm">Entende-se por <strong>PRODUÇÃO NA ESPANHA</strong> a finalização do
                            projeto executivo ParkEyes FULL,
                            das listas de equipamentos e a separação e embalagem de todos os produtos
                            ParkEyes (câmeras, painéis, servidor, elementos de cabeamento) que serão entregues ao
                            COMPRADOR
                        </li>

                        <li class="ht-70 col-sm">Entende-se por <strong>PEDIDO DE INFRAESTRUTURA</strong> a compra e
                            entrega de todas as
                            eletrocalhas, eletrodutos,
                            elementos de suporte, uniões, e derivações a serem instalados no estacionamento.</li>

                        <li class="ht-70 col-sm">Entende-se por <strong>TRÂNSITO INTERNACIONAL</strong> a coleta do
                            produto ParkEyes desde a
                            sede da IMAGiNA Visión Artificial S.L.
                            em Málaga na Espanha até a sua nacionalização em território brasileiro.</li>

                        <li class="ht-70 col-sm">Entende-se por <strong>ENTREGA PARKEYES</strong> a conferência e
                            preparação do produto
                            ParkEyes na sede da
                            SB Trade Comércio Exterior em São José, SC, agendamento e entrega no endereço do cliente.
                        </li>

                        <li class="ht-70 col-sm">Entende-se por <strong>INSTALAÇÃO PARKEYES</strong> a montagem do
                            produto ParkEyes na
                            infraestrutura ParkEyes já instalada e interligação com o Centro de Controle</li>

                        <li class="ht-70 col-sm">Entende-se por <strong>AJUSTE FINO</strong> o enquadre de todas as
                            câmeras do sistema na
                            visualização de sua respectiva vaga,
                            instalação de software e treinamento de operadores indicados pelo cliente.</li>
                    </ol>
                </div>

                <hr>

                @foreach ($estruturaProposta as $key=>$val)

                
                <div>
                    <div class="row row-sm">
                        <div class="col-md">
                            <h5>{{$val->nomeParque}}</h5>
                            @if($val->imagem!='')
                                <figure class="pos-relative mg-b-0 wd-lg-50p">
                                    <img src="/files/{{$val->imagem}}" class="img-thumbnail" width="278" height="183">
                                   
                                </figure>
                           
                            @else
                                <figure class="pos-relative mg-b-0 wd-lg-50p">
                                    <img src="/img/parque-dafault.png" class="img-thumbnail" width="278" height="183">
                                    
                                </figure>
                            
                            @endif
                        </div><!-- col -->
    
                        @if($val->parqueCentralizado)
                            <div class="divider-text"><-- {{$val->distanciaCentralizado}} m --></div>
                            <div class="col-md mg-t-10 mg-md-t-0 mg-l-60">
                                <figure class="img-caption pos-relative mg-b-0">
                                    <img src="/img/central-comando.jpeg" class="img-thumbnail" width="248" height="153">
    
                                </figure>
                            </div><!-- col -->
                            
                        @else
    
                            <div class="col-md mg-t-10 mg-md-t-0">&nbsp;</div>
    
                        @endif
                    </div><!-- row -->
     
    
                    @if($key+1 != $estruturaProposta->count())
                        <div class="row row-sm">
                            <div class="col-md-6"></div>
                            <div class="divider-text divider-vertical" data-text="">{{$val->distanciaEntreParques}} m</div>
                            <div class="col-md mg-t-6 mg-md-t-0">
                                <br><br>
                                <br>
                                <br>
                                <br>
                            </div><!-- col -->
                        </div>
                    @endif
                </div>    
                @endforeach

                <hr>
                <div class="card">
                    <div class="card-header tx-bold">
                        Considerações Finais
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">O valor exato e final do projeto será conhecido mediante o
                                Projeto Executivo ParkEyes onde constará o quantitativo exato de materiais empregados na
                                intalação.</li>
                            <li class="list-group-item">A compra de produtos não relacionados a um projeto será
                                realizada mediante tabela de preços independente.</li>
                            <li class="list-group-item">Preços validos para projetos dentre setecentos e três mil vagas.
                            </li>
                            <li class="list-group-item">Todas as propostas editadas nesta simulação estão sujeitas ao
                                Aceite final da SB Trade.</li>
                            <li class="list-group-item">Câmbo EUR/BRL referência 4,50</li>
                        </ul>
                    </div>
                </div>

                <hr>
                <div class="card">
                    <div class="card-header tx-bold">
                        Notas de Visita Técnica e Observações:
                    </div>
                    <div class="card-body">
                      {{$notas->valor}}
                    </div>
                </div>


                <div class="row pd-t-150 ">

                    <div class="wd-400  mg-l-auto mg-r-auto ht-80">

                        <hr style="border-color:black !important;">
                        <div style="margin:0 auto;">
                            <p style="margin:0 auto; text-align:center;">
                                <strong>{{$proposta['responsavel']}}</strong>
                                <br>
                                <strong>{{$proposta['estabelecimento']}}</strong>
                                <br>
                                (Favor rubricar todas as páginas deste orçamento)
                            </p>
                        </div>
                    </div>

                </div>
            </div><!-- row -->
        </div>


    </div><!-- container -->

</div>

@endsection


@section('js')

<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('js/dashforge.js')}}"></script>

<!-- append theme customizer -->
<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('lib/jquery.maskMoney/jquery.maskMoney.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jspdf.js')}}"></script>


<style>
    /*
        Use the DejaVu Sans font for display and embedding in the PDF file.
        The standard PDF fonts have no support for Unicode characters.
    */
    .pdf-page {
        font-family: "DejaVu Sans", "Arial", sans-serif;
    }

    .pdf-page {
        margin: 0 auto;
        box-sizing: border-box;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .3);
        background-color: #fff;
        color: #333;
        position: relative;
    }

    .pdf-header {
        position: absolute;
        top: .5in;
        height: .6in;
        left: .5in;
        right: .5in;
        border-bottom: 1px solid #e5e5e5;
    }

    .pdf-footer {
        position: absolute;
        bottom: .5in;
        height: .6in;
        left: .1in;
        right: .1in;
        padding-top: 10px;
        border-top: 1px solid #e5e5e5;
        text-align: left;
        color: #787878;
        font-size: 12px;
    }

    .pdf-body {
        position: absolute;
        top: 3.7in;
        bottom: 1.2in;
        left: .5in;
        right: .5in;
    }

    .size-a4 {
        width: 8.3in;
        height: 11.7in;
    }

    .size-letter {
        width: 8.5in;
        height: 11in;
    }

    .size-executive {
        width: 7.25in;
        height: 10.5in;
    }

    .company-logo {
        font-size: 30px;
        font-weight: bold;
        color: #3aabf0;
    }

    .for {
        position: absolute;
        top: 1.5in;
        left: .5in;
        width: 2.5in;
    }

    .from {
        position: absolute;
        top: 1.5in;
        right: .5in;
        width: 2.5in;
    }

    .from p,
    .for p {
        color: #787878;
    }

    .signature {
        padding-top: .5in;
    }
</style>



<script>
    // Import DejaVu Sans font for embedding

    // NOTE: Only required if the Kendo UI stylesheets are loaded
    // from a different origin, e.g. cdn.kendostatic.com
    kendo.pdf.defineFont({
        "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
        "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
        "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
    });
</script>

<script>
    $(document).ready(function () {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
            
    
        function ExportPdf(){ 
            $.ajax({
                type: "POST",
                url: "/propostas/saveServerSide",
                data: {'imageData' : $("#canvas").html(), 'propostaId'  : $("#propostaID").val() },
                success: function(data){
                    if(data.success){
                        alert("Conteúdo salvo no servidor.");
                    }
                },error: function(){
                    alert('Erro no Ajax !');
                }
            });      
        }
     

        $('#exportarProposta').click(function(e) {
            ExportPdf();
        });

        $(".table").hide();
        
        $("table").has("tbody td").show().after("<hr>");
        //$(".total").maskMoney();
        $('.somarTabela tr').each(function(){
                var total = 0;

                var valor       = $(this).find('.valor').val();
            
                var quantidade  = $(this).find('.quantidade').val();
                if(quantidade === ''){
                    quantidade = 1;
                }
                valorTotal      = parseFloat(valor)*parseFloat(quantidade);
     
                total           += valorTotal;
                
                $(this).find('.valorTotal').val(total);
                $(this).find('.totalSpan').text("R$ " + formatMoney(total));
        
        });

    
    $(function(){
        var vTotalTb1 = 0;
        var vTotalTb2 = 0;
        var vTotalTb3 = 0;
        var vTotalTb4 = 0;

       
        $('#tbl1 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
               
                vTotalTb1 += parseFloat(valor);
        });
        console.log("TBL 1 " + vTotalTb1);

        $('#tbl2 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                
                vTotalTb2 += parseFloat(valor);
        });
        console.log("TBL 2 " + vTotalTb2);
        $('#tbl3 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                
                vTotalTb3 += parseFloat(valor);
        });
        console.log("TBL 3 " + vTotalTb3);
        $('#tbl4 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                
                vTotalTb4 += parseFloat(valor);
        });
        console.log("TBL 4 " + vTotalTb4);
     


        $("#tbl1").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb1) + "</strong>");
        $("#tbl2").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb2) + "</strong>");
        $("#tbl3").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb3) + "</strong>");
        $("#tbl4").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb4) + "</strong>");
       
        var valorGrupo1 = vTotalTb1+vTotalTb2+vTotalTb3;
        var totalSistemaInstalacao = valorGrupo1+vTotalTb4;
        console.log('grupo1 ' + valorGrupo1);
        var totalDeVagasInternas = $("#totalDeVagasInternas").val();
        var totalDeVagas         = $("#totalDeVagas").val();
        var totalPorVagaInternas = totalSistemaInstalacao/totalDeVagasInternas;
        var totalPorVaga         = totalSistemaInstalacao/totalDeVagasInternas;
        $("#totalSistemParkEyes").html("<strong>R$ " +formatMoney(valorGrupo1) + "</strong>");
        $("#instalacaoSistemaParkEyes").html("<strong>R$ "+formatMoney(vTotalTb4)+"</strong>");
        $(".totalSistemaInstalacao").html("<strong>R$ "+formatMoney(totalSistemaInstalacao)+"</strong>");
        $(".totalPorVaga").html("<strong>R$ "+formatMoney(totalPorVaga)+"</strong>");
        $(".totalPorVagaInterna").html("<strong>R$ "+formatMoney(totalPorVagaInternas)+"</strong>");

        var primeiraParcela = vTotalTb1+vTotalTb2;
        $("#primeiraGrupo1").html("<strong>1ª R$ " +formatMoney(primeiraParcela*0.50) + "</strong>");
        $("#segundaGrupo1").html("<strong>2ª R$ " +formatMoney(primeiraParcela*0.20) + "</strong>");
        $("#terceiraGrupo1").html("<strong>3ª R$ " +formatMoney(primeiraParcela*0.30) + "</strong>");
        $("#totalGrupo1").html("<strong>Total - R$ " +formatMoney(primeiraParcela) + "</strong>");
        
        var segundaParcela = vTotalTb3+vTotalTb4;

        $("#primeiraGrupo2").html("<strong>1ª R$ " +formatMoney(segundaParcela*0.50) + "</strong>");
        $("#segundaGrupo2").html("<strong>2ª R$ " +formatMoney(segundaParcela*0.20) + "</strong>");
        $("#terceiraGrupo2").html("<strong>3ª R$ " +formatMoney(segundaParcela*0.30) + "</strong>");
        $("#totalGrupo2").html("<strong>Total - R$ " +formatMoney(segundaParcela) + "</strong>");
    });
   

});    

function formatMoney(n, c, d, t) {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

</script>

@endsection