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
            <li class="breadcrumb-item active" aria-current="page">Regerando Proposta</li>
        </ol>


        <h4 id="section4" class="mg-b-10">Regerando Proposta</h4>

        <div class="tx-14 mg-b-25">
            <form method="POST" action="/propostas/regerarNova/{{$cliente_id}}">

                @csrf
                <input type="hidden" name="cliente_id" value="{{$cliente_id}}" />
                <input type="hidden" name="proposta_id" class="proposta_id" value="{{$proposta->id}}" />
                <input type="hidden"   name="tipo_proposta" value="{{$tipo_proposta}}" />
                <div id="wizard4">


                    <h3>Informações do Estabelecimento</h3>
                    <section>
                        <div class="row row-sm">
                            <div class="form-group col-sm-2">
                                <label for="cep">CEP</label>
                                <input type="text" class="form-control cep" size="10" value="{{$proposta->cep}}"
                                    maxlength="9" id="cep" name="cep" />
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="rua">Rua</label>
                                <input type="text" class="form-control" id="rua" value="{{$proposta->rua}}"
                                    name="rua" />
                            </div>

                            <div class="form-group col-sm-3">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" value="{{$proposta->cidade}}"
                                    name="cidade" />
                            </div>

                            <div class="form-group col-sm-1">
                                <label for="uf">UF</label>
                                <input type="text" class="form-control" id="uf" value="{{$proposta->uf}}" name="uf" />
                            </div>
                        </div>

                        @foreach($perguntas as $pergunta)

                        @if($pergunta['categoria_id'] == 1)
                        <div class="form-row">
                            <label for="{{$pergunta['id_campo']}}" class="d-block">{!! $pergunta['pergunta'] !!}</label>
                            @if($pergunta['tipo_campo'] == 1)

                            <input type="text" @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif
                                @if(!empty($pergunta['id']))
                                value="{!! Helper::procuraRespostas($pergunta['id'], $proposta_id) !!}" @endif
                                class="form-control">



                            @elseif($pergunta['tipo_campo'] == 2)
                            <textarea @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control"
                                rows="5">

                                        @if(!empty($pergunta['id']))
                                            {!! Helper::procuraRespostas($pergunta['id'], $proposta_id) !!}
                                        @endif
                                    </textarea>

                            @elseif($pergunta['tipo_campo'] == 3)
                            <div class="form-group col-md-12">
                                <select @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                    @if(!empty($pergunta['name_campo']))
                                    name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="custom-select">
                                    @foreach(Helper::retornaRespostas($pergunta['id']) as $key=>$val)
                                    <option value="{{$val['valor']}}"
                                        {{ $val['opcao_selecionada'] == 0 ? 'selected' : '' }}>{{$val['valor']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if($pergunta['html_apendice'] != '')
                            {!! $pergunta['html_apendice'] !!}
                            @endif

                            @elseif($pergunta['tipo_campo'] == 4)
                            <input type="number" @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}"
                                @endif @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control"
                                @if(!empty($pergunta['id']))
                                value="{!! Helper::procuraRespostas($pergunta['id'], $proposta_id) !!}" @endif>
                            @endif
                        </div>
                        @endif
                        @endforeach
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
                                @foreach($estruturas as $estrutura)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger rounded-pill removeRow">x</button>
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="nomeParque" name="nomeParque[]"
                                            value="{{$estrutura->nomeParque}}">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" id="quantidadeVagasInternas"
                                            name="quantidadeVagasInternas[]" value="{{$estrutura->qtdVagasInternas}}">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" id="quantidadeVagasExternas"
                                            name="quantidadeVagasExternas[]" value="{{$estrutura->qtdVagasExternas}}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="alturaSistema"
                                            name="alturaSistema[]" value="{{$estrutura->alturaSistema}}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="peDireito" name="peDireito[]"
                                            value="{{$estrutura->alturaPeDireito}}">
                                    </td>

                                    <td>
                                        <select name="parqueMaisCentralizado[]" class="custom-select radioCentralizado">
                                            <option value="0"
                                                {{ $estrutura->parqueCentralizado == 0 ? "selected" : ""}}>Não</option>
                                            <option value="1"
                                                {{ $estrutura->parqueCentralizado == 1 ? "selected" : ""}}>Sim</option>
                                        </select>
                                    </td>
                                    <td>
                                    @if($estrutura->distanciaCentralizado!=0)
                                    <input type="text" class="form-control distancias" id="distanciaEntreParques"
                                    placeholder="Rel. Centralizado." name="distanciaEntreParques[]" value="{{$estrutura->distanciaCentralizado}}" />
                                    @else 
                                    <input type="text" class="form-control distancias" id="distanciaEntreParques"
                                    placeholder="Rel. Centralizado." name="distanciaEntreParques[]" value="{{$estrutura->distanciaEntreParques}}" />
                                    @endif
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary rounded-pill add-row">
                            Adicionar Andar/Nível
                        </button>

                        <hr>

                        @foreach($perguntas as $pergunta)
                        @if($pergunta['categoria_id'] == 2)
                        <div class="form-row">
                            <label for="estabelecimento" class="d-block">
                                 {!! $pergunta['pergunta'] !!}
                            </label>

                            @if($pergunta['tipo_campo'] == 1)
                            <input type="text" @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif
                                @if(!empty($pergunta['id']))
                                value="{!! Helper::procuraRespostas($pergunta['id'],$proposta_id) !!}" @endif
                                class="form-control">


                            @elseif($pergunta['tipo_campo'] == 2)
                            <textarea @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control"
                                rows="5">{!! Helper::procuraRespostas($pergunta['id'],$proposta_id) !!}
                                    </textarea>

                            @elseif($pergunta['tipo_campo'] == 3)
                            <div class="form-group col-md-12">
                                <select @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                    @if(!empty($pergunta['name_campo']))
                                    name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="custom-select">
                                    @foreach(Helper::retornaRespostas($pergunta['id']) as $key=>$val)
                                    <option value="{{$val['valor']}}"
                                        {{ Helper::procuraRespostas($pergunta['id'],$proposta_id) == $val['valor'] ? 'selected' : '' }}>
                                        {{$val['valor']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            @if(Helper::procuraRespostas($pergunta['id'],$proposta_id) == 'Sim')
                            @if($pergunta['html_apendice'] != '')
                            {!! $pergunta['html_apendice'] !!}
                            @endif
                            @endif

                            @elseif($pergunta['tipo_campo'] == 4)
                            <input type="number" @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}"
                                @endif @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control"
                                @if(!empty($pergunta['id']))
                                value="{!! Helper::procuraRespostas($pergunta['id'], $proposta_id) !!}" @else value="0"
                                @endif>
                            @endif

                        </div>
                        @endif
                        @endforeach
                    </section>


                    @if( isset($isBasic) and $isBasic == false)
                    <h3>Find Your Car</h3>
                    <section>
                        @foreach($perguntas as $pergunta)
                        @if($pergunta['categoria_id'] == 3)
                        <div class="form-row">
                            <label for="estabelecimento" class="d-block">{!! $pergunta['pergunta'] !!}</label>
                            @if($pergunta['tipo_campo'] == 1)
                            <input type="text" value="{!! Helper::procuraRespostas($pergunta['id'],$proposta_id) !!}"
                                 @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control">
                            @elseif($pergunta['tipo_campo'] == 2)
                            <textarea @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control"
                                rows="5">
                                    </textarea>
                            @elseif($pergunta['tipo_campo'] == 3)
                            <div class="form-group col-md-12">
                                <select @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}" @endif
                                    @if(!empty($pergunta['name_campo']))
                                    name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="custom-select">
                                    @foreach(Helper::retornaRespostas($pergunta['id']) as $key=>$val)
                                    <option value="{{$val['valor']}}"
                                        {{ Helper::procuraRespostas($pergunta['id'],$proposta_id) == $val['valor'] ? 'selected' : '' }}>
                                        {{$val['valor']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if($pergunta['html_apendice'] != '')
                            {!! $pergunta['html_apendice'] !!}
                            @endif
                            @elseif($pergunta['tipo_campo'] == 4)
                            <input type="number" value="{!! Helper::procuraRespostas($pergunta['id'],$proposta_id) !!}" @if(!empty($pergunta['id_campo'])) id="{{$pergunta['id_campo']}}"
                                @endif @if(!empty($pergunta['name_campo']))
                                name="{{$pergunta['name_campo']}}_{{$pergunta['id']}}" @endif class="form-control"
                                value="0">
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </section>
                    @endif
                </div>
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
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
       

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#rua").val("");
            $("#cidade").val("");
            $("#uf").val("");
        }
        'use strict'
        $(document).ready(function() {
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
        
                onFinishing: function (event, currentIndex) { 
                    $("#enviarForm").trigger('click');
                    return true; 
                }
            });

         

            $(".cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if(cep != ""){
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
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
            rows += '<td>';
            rows += '<input type="text" class="form-control" id="distanciaEntreParques" placeholder="Rel. Centralizado." name="distanciaEntreParques[]" />';
            rows += '</td>';
            rows += '</tr>';
            $("#tabelaParques > tbody:last").append(rows);
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
            var totalSelecionado = $("#quantidadeAcessosExternos option:selected").text();
            console.log(totalSelecionado);
            for (var tamanhoPadrao = 0; tamanhoPadrao < totalSelecionado; tamanhoPadrao++) {
                $colunaGrupo.append($coluna.clone());
                $colunaPaineisGrupo.append($colunaPaineis.clone());
                $colunaDistanciaLinhasGrupo.append($colunaDistanciaLinhas.clone());
            }
        });


        $("#possuiCamerasExtras").change(function() {
            if (this.options[this.selectedIndex].text == 'Sim') {
                $(this).closest("div").removeClass("col-md-12");
                $(this).closest("div").addClass("col-md-6");
                $('#quantidadeCamerasDiv').show();
            } else if (this.options[this.selectedIndex].text == 'Não') {
                $(this).closest("div").removeClass("col-md-6");
                $(this).closest("div").addClass("col-md-12");
                $('#quantidadeCamerasDiv').hide();
            }
        }).trigger("change");


        $("#camerasExtrasLPR").change(function() {
            if (this.options[this.selectedIndex].text == 'Sim') {
                $(this).closest("div").removeClass("col-md-12");
                $(this).closest("div").addClass("col-md-6");
                $('#quantidadeCamerasExtrasLPR').show();
            } else if (this.options[this.selectedIndex].text == 'Não') {
                $(this).closest("div").removeClass("col-md-6");
                $(this).closest("div").addClass("col-md-12");
                $('#quantidadeCamerasExtrasLPR').hide();
            }
        }).trigger("change");

        $("#camerasLPR").change(function() {
            if (this.options[this.selectedIndex].text == 'Sim') {
                $(this).closest("div").removeClass("col-md-12");
                $(this).closest("div").addClass("col-md-6");
                $('#quantidadeCamerasLPRDiv').show();
            } else if (this.options[this.selectedIndex].text == 'Não') {
                $(this).closest("div").removeClass("col-md-6");
                $(this).closest("div").addClass("col-md-12");
                $('#quantidadeCamerasLPRDiv').hide();
            }
        }).trigger("change");

        

        $("#tabelaParques .radioCentralizado").change(function(){
            //$(".radioCentralizado").removeAttr("selected","").val(0);
            //$(this).attr('selected',"selected").val(1);
            if(this.options[this.selectedIndex].text == 'Sim'){
               // var valor = retornaValorCampo('distanciaCentralizado');
                //console.log(valor);
                var idCampo = $(this).closest('td').next('td').find('#distanciaEntreParques').attr('placeholder', '+ Centralizado');
                $(".radioCentralizado").removeAttr("selected","").val(0);
                $(this).attr('selected',"selected").val(1);
            }else{
              //var valor = retornaValorCampo('distanciaEntreParques');
               //console.log(valor);
               var idCampo = $(this).closest('td').next('td').find('#distanciaEntreParques').attr('placeholder', 'Rel. Centralizado.');
            }
        }).trigger("change");


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        function retornaValorCampo(tipo){
            var token = $('meta[name="_token"]').attr('content');
            var tp = tipo;
            var urlEnviar = '/propostas/valorCampo';
            var proposta_id = $(".proposta_id").val();
            $.ajax({
                type: 'POST',
                url: urlEnviar,
                data: { '_token': token, 'tipo'  : tp, 'proposta_id': proposta_id },
                success: function(data){
                    if(data.success){
                        //console.log(data.valor);
                           return data.valor;
                    }
                   
                },
                error: function(){
                    console.log('Erro no Ajax !');
                }
            });

            return false;
          
        }
            
       
        $('[data-toggle="tooltip"]').tooltip();
        });
    });
</script>

@endsection