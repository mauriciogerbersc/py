@extends('layouts.app', ["current"=>"propostas"])


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
            <li class="breadcrumb-item"><a href="/propostas">Propostas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nova Proposta</li>
        </ol>


        <h4 id="section4" class="mg-b-10">Nova Proposta</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/propostas/nova/{{$cliente->id}}">

                @csrf
                <input type="hidden" name="cliente_id" value="{{$cliente->id}}" />
                <div id="wizard4">

                    <h3>Informações do Estabelecimento</h3>
                    <section>

                        <div class="form-group">
                            <label for="estabelecimento" class="d-block">A qual shopping destina-se esse
                                projeto?</label>
                            <input type="text" class="form-control" name="estabelecimento" id="estabelecimento" required
                                placeholder="Informe o nome do Estabelecimento">
                        </div>

                        <div class="form-group">
                            <label for="nomeEmitido" class="d-block">Em nome de quem a proposta será emitida?</label>
                            <input type="text" class="form-control" name="responsavel" id="responsavel" required
                                placeholder="Informe o nome do responsável">
                        </div>

                    </section>

                    <h3>Estrutura do Estabelcimento</h3>
                    <section>
                        <p class="mg-b-0">Quantos andares, níveis ou parques de
                            estacionamento comtemplam o seu Shopping?</p>
                        <table class="table" id="tabelaParques">

                            <thead>
                                <tr>
                                    <th>Remover?</th>
                                    <th>Nome Parque</th>
                                    <th>Vagas Internas Cobertas</th>
                                    <th>Vagas Externas</th>
                                    <th>Altura do Sistema</th>
                                    <th>
                                        Pé direito (Em metros)
                                        <span class="badge badge-primary" style="padding:5px 4px !important;">
                                            <i class="icon ion-md-help" data-toggle="tooltip" data-placement="bottom"
                                                title="Informe a altura desejada do sistema dentre 2 metros e 2,5 metros do chão, de acordo com a possibilidade de seu 
                                                    estacionamento e considerando 2,4 metros como altuara ideal. Informe o pé-direito de cada parque coberto"></i>
                                        </span>
                                    </th>
                                    <th>Parque mais centralizado</th>

                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger rounded-pill removeRow">x</button>
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="nomeParque" name="nomeParque[]"
                                            placeholder="Ex: G1">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" id="quantidadeVagasInternas"
                                            name="quantidadeVagasInternas[]" value="0">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" id="quantidadeVagasExternas"
                                            name="quantidadeVagasExternas[]" value="0">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="alturaSistema"
                                            name="alturaSistema[]" value="0">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="peDireito" name="peDireito[]"
                                            value="0">
                                    </td>

                                    <td>
                                        <select name="parqueMaisCentralizado[]" class="custom-select radioCentralizado">
                                            <option value="0" selected>Não</option>
                                            <option value="1">Sim</option>
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary rounded-pill add-row">
                            Adicionar Andar/Nível
                        </button>

                        <hr>

                        <div class="form-group">
                            <label for="sistemaGravacao" class="d-block">
                                O sistema ParkEyes Basic é oferecido com 24 horas de gravação incluso.
                                Se desejar a ampliação de dias de gravação do sistema, favor inserir o número de dias
                                extras.
                            </label>
                            <input type="number" name="qtdDiasDeGravacao" class="form-control" value="5">
                        </div>

                        <div class="form-row">
                            <label for="sistemaGravacao" class="d-block">
                                Se você gostaria de instalar câmeras em locais estratégicos como corredores, hall de
                                entrada, depósitos,
                                etc..., além das que estão monitorando as vagas?</label>
                            <div class="form-group col-md-12">
                                <select id="possuiCamerasExtras" name="possuiCamerasExtras" class="custom-select">
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="quantidadeCamerasDiv">
                                <input type="number" class="form-control" name="quantidadeCamerasExtras" value="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="quantosPaineisSinalizados" class="d-block">Quantos painéis de sinalização de
                                vagas internos você gostaria de instalar?
                                Dê preferência a cruzamentos e pontos de tomada de decisão do cliente para que ele
                                seja consuzido a locais mais amplos e com mais vagas.</label>
                            <input type="number" class="form-control" name="quantosPaineisSinalizados" value="0">
                        </div>

                        <div class="form-group">
                            <label for="" class="d-block">
                                Qual a distância em metros entre o Centro de Controle e o Parque mais centralizado?
                                Neste local ficará a caixa principal de distribuição</label>
                            <input type="number" class="form-control" name="distanciaCentroControle" value="0">
                        </div>

                        <div class="form-group">
                            <label for="" class="d-block">
                                Some as distâncias de interligação do Parque mais centralizado até os demais parques de estacionamento,
                                considerando os shafts de passagem disponíveis
                            </label>
                            <input type="text" class="form-control" name="distanciaEntreParques" value="0">
                        </div>

                        <div class="form-row">
                            <label for="" class="d-block">O ParkEyes Outdoor é um sistema de controle de número de
                                veículos dentro de
                                um parque de estacionamento descoberto, se há interesse nesse controle, favor informar o
                                número de entradas e
                                saídas que acessam a totalidade dos parques descobertos.</label>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="qtdEntradas" value="0"
                                    placeholder="entradas">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="qtdSaidas" value="0" placeholder="saídas">
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="sistemaGravacao" class="d-block">Deseja instalar câmeras LPR para leitura de
                                placar quanto um veículo acessa,
                                ou sai de um parque de estacionamento descoberto?</label>

                            <div class="form-group col-md-12">
                                <select id="camerasExtrasLPR" name="camerasExtrasLPR" class="custom-select">
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="quantidadeCamerasExtrasLPR">
                                <input type="number" class="form-control" name="quantidadeCamerasExtrasLPR" value="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="quantidadeAcessosExternos" class="d-block">
                                Quantos acessos externos possui Shopping? Considerando as caixas de passagem e shafts
                                disponíveis no Shopping,
                                informe também a distância de cada acesso externo até o parque de estacionamento coberto
                                mais próximo.
                            </label>
                            <div class="form-group col-md-12">
                                <select id="quantidadeAcessosExternos" name="qtdAcessosExternos" class="custom-select">
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="acessosExternos">
                            <div class="form-group col-md-4  d-flex align-items-end" id="paraClonar">
                                <input type="text" class="form-control" name="nomeAcessoExterno[]"
                                    placeholder="Nomeie o acesso">
                            </div>
                        </div>

                        <div class="form-row linhasPaineis">
                            <label class="d-block">Informe quantas linhas serão necessárias para os painéis externos
                                localizados nos seguintes acessos?</label>
                        </div>

                        <div class="form-row" id="linhasPaineis">
                            <div class="form-group col-md-4 d-flex align-items-end" id="paraClonarPaineis">
                                <input type="number" name="quantidadeLinhasPaineis[]" class="form-control">
                            </div>
                        </div>

                        <div class="form-row distanciaLinhas">
                            <label class="d-block">Informe a distância do acesso abaixo até o parque de estacionamento
                                coberto mais próximo?</label>
                        </div>

                        <div class="form-row" id="distanciaLinhas">
                            <div class="form-group col-md-4  d-flex align-items-end" id="paraClonarDistanciaLinhas">
                                <input type="text" name="distanciaAcessoProximo[]" class="form-control">
                            </div>
                        </div>


                        <div class="form-row">
                            <label for="camerasLPR" class="d-block">Deseja instalar câmeras LPR para leitura de placas
                                quando um veículo acessa,
                                ou sai das cancelas de seu estaciomento?</label>
                            <div class="form-group col-md-12">

                                <select id="camerasLPR" name="camerasLPR" class="custom-select">
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="quantidadeCamerasLPRDiv">
                                <input type="number" name="quantidadeCamerasLPR" class="form-control" value="0">
                            </div>
                        </div>


                    </section>

                    <h3>Find Your Car</h3>
                    <section>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="totensFindYourCar" class="d-block">
                                    Quantos Totens de sistema de localização
                                    de veículos <strong>"Find Your Car"</strong> serão instalados no Shopping? (Dê
                                    preferência a colocação de um totem ao lado de cada guichê de cobrança de
                                    estacionamento)
                                </label>
                            </div>

                            <div class="form-group col-md-6">
                                <input type="number" name="qtdTotensFindYorCar" class="form-control" value="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="camerasLPR" class="d-block">Aplicativo ParkEyes</label>
                            </div>

                            <div class="form-group col-md-6">
                                <select id="aplicativoParkEyes" name="aplicativoParkEyes" class="custom-select">
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="camerasLPR" class="d-block">API para aplicativo de cliente</label>
                            </div>

                            <div class="form-group col-md-6">
                                <select id="apiAplicativoCliente" name="apiAplicativoCliente" class="custom-select">
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="camerasLPR" class="d-block">API para Tótens de outras empresas*</label>
                            </div>

                            <div class="form-group col-md-6">
                                <select id="quantidadeCamerasLPR" name="apiParaTotens" class="custom-select">
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <h3>Plantas do Shopping</h3>
                    <section>
                        <p class="mg-b-0">adasdasdasdsa.</p>
                    </section>
                </div>

                <input type="submit" style="display:none;" id="enviarForm">
            </form>
        </div><!-- df-example -->


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
<script src="{{asset('lib//parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('lib/jquery-steps/build/jquery.steps.min.js')}}"></script>

<script src="{{asset('js/dashforge.js')}}"></script>


<script>
    $(function() {
        'use strict'
        $('#wizard4').steps({
            headerTag: 'h3',
            bodyTag: 'section',
            autoFocus: true,
            labels: {
                next: 'Próximo',
                previous: 'Anterior',
                finish: 'Finalizar'
            },
            titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
            onStepChanging: function (event, currentIndex, newIndex) {
                if(currentIndex < newIndex) {
                    // Step 1 form validation
                    if(currentIndex === 0) {
                        var responsavel = $('#responsavel').parsley();
                        var estabelecimento = $('#estabelecimento').parsley();

                        if(responsavel.isValid() && estabelecimento.isValid()) {
                            return true;
                        } else {
                            responsavel.validate();
                            estabelecimento.validate();
                        }
                    }

              
                // Always allow step back to the previous step even if the current step is not valid.
                } else { 
                    return true; 
                }
            },
            onFinishing: function (event, currentIndex) { 
                $("#enviarForm").trigger('click');
                return true; 
            }
        });


        $(".add-row").click(function() {
            var rows = '';
            rows += '<tr>';
            rows += '<td>';
            rows += '<button type="button" class="btn btn-danger rounded-pill removeRow">x</button>';
            rows += '</td>';
            rows += '<td>';
            rows += '<input type="text" class="form-control" id="nomeParque" name="nomeParque[]"  placeholder="Ex: G1">';
            rows += '</td>';
            rows += '<td>';
            rows += '<input type="number" class="form-control" id="quantidadeVagasInternas" name="quantidadeVagasInternas[]" value="0">';
            rows += '</td>';
            rows += '<td>';
            rows += '<input type="number" class="form-control" id="quantidadeVagasExternas" name="quantidadeVagasExternas[]" value="0" >';
            rows += '</td>';
            rows += '<td>';
            rows += '<input type="text" class="form-control" id="alturaSistema" name="alturaSistema[]" value="0">';
            rows += '</td>';
            rows += '<td>';
            rows += '<input type="text" class="form-control" id="peDireito" name="peDireito[]" value="0">';
            rows += '</td>';
            rows += '<td>';
            rows += '<select name="parqueMaisCentralizado[]" class="custom-select radioCentralizado"><option value="0" selected>Não</option><option value="1">Sim</option></select>';
            rows += '</td>';
            rows += '</tr>';
            $("#tabelaParques > tbody:last").append(rows);
        });

        $("#tabelaParques").on("change", ".radioCentralizado", function(){
            $(".radioCentralizado").removeAttr("selected","").val(0);
            $(this).attr('selected',"selected").val(1);
           // $(this).val(1);
        });

        $("#tabelaParques").on("click", ".removeRow", function() {
            $(this).closest("tr").remove();
        });

        $('#quantidadeCamerasLPRDiv').hide();
        $("#quantidadeCamerasExtrasLPR").hide();
        $("#quantidadeCamerasDiv").hide();
        $("#acessosExternos").hide();
        $("#linhasPaineis").hide();
        $("#distanciaLinhas").hide();
        $(".linhasPaineis").hide();
        $(".distanciaLinhas").hide();


        var $colunaGrupo = $("#acessosExternos");
        var $colunaPaineisGrupo = $("#linhasPaineis");
        var $colunaDistanciaLinhasGrupo = $("#distanciaLinhas");

        var $coluna = $colunaGrupo.children("div");
        var $colunaPaineis = $colunaPaineisGrupo.children("div");
        var $colunaDistanciaLinhas = $colunaDistanciaLinhasGrupo.children("div");
        var tamanhoPadrao = $coluna.length;

        $("#quantidadeAcessosExternos").change(function() {
            $colunaGrupo.html("");
            $colunaPaineisGrupo.html("");
            $colunaDistanciaLinhasGrupo.html("");
            $("#acessosExternos").show();
            $("#linhasPaineis").show();
            $("#distanciaLinhas").show();
            $(".linhasPaineis").show();
            $(".distanciaLinhas").show();
            var totalSelecionado = $("#quantidadeAcessosExternos").val();
            for (var tamanhoPadrao = 0; tamanhoPadrao < totalSelecionado; tamanhoPadrao++) {
                $colunaGrupo.append($coluna.clone());
                $colunaPaineisGrupo.append($colunaPaineis.clone());
                $colunaDistanciaLinhasGrupo.append($colunaDistanciaLinhas.clone());
            }
        });

        $("#possuiCamerasExtras").change(function() {
            if (this.options[this.selectedIndex].value == '1') {
                $(this).closest("div").removeClass("col-md-12");
                $(this).closest("div").addClass("col-md-6");
                $('#quantidadeCamerasDiv').show();
            } else if (this.options[this.selectedIndex].value == '0') {
                $(this).closest("div").removeClass("col-md-6");
                $(this).closest("div").addClass("col-md-12");
                $('#quantidadeCamerasDiv').hide();
            }
        });


        $("#camerasExtrasLPR").change(function() {
            if (this.options[this.selectedIndex].value == '1') {
                $(this).closest("div").removeClass("col-md-12");
                $(this).closest("div").addClass("col-md-6");
                $('#quantidadeCamerasExtrasLPR').show();
            } else if (this.options[this.selectedIndex].value == '0') {
                $(this).closest("div").removeClass("col-md-6");
                $(this).closest("div").addClass("col-md-12");
                $('#quantidadeCamerasExtrasLPR').hide();
            }
        });

        $("#camerasLPR").change(function() {
            if (this.options[this.selectedIndex].value == '1') {
                $(this).closest("div").removeClass("col-md-12");
                $(this).closest("div").addClass("col-md-6");
                $('#quantidadeCamerasLPRDiv').show();
            } else if (this.options[this.selectedIndex].value == '0') {
                $(this).closest("div").removeClass("col-md-6");
                $(this).closest("div").addClass("col-md-12");
                $('#quantidadeCamerasLPRDiv').hide();
            }
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@endsection