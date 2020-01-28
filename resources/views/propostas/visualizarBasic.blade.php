@extends('layouts.app', ["current" => "propostas"])

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


<form method="POST" action="/propostas/gerarProposta/{{$proposta->id}}">
    @csrf
    <div class="content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">

            <ol class="breadcrumb df-breadcrumbs mg-b-10">
                <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                <li class="breadcrumb-item"><a href="/propostas">Proposta</a></li>
            </ol>

            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-5">Proposta #{{$proposta->id}}</h4>
                    <p class="mg-b-0 tx-color-03">{!! Helper::formataDataHora($proposta->created_at) !!}</p>
                </div>
                <div class="mg-t-20 mg-sm-t-0">
                    <input type="hidden" id="idProposta" value="{{$proposta->id}}" />
                    <a href="/propostas/gerarProposta/{{$proposta->id}}" class="btn btn-primary mg-l-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-credit-card mg-r-5">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg> Gerar Proposta
                    </a>
                </div>
            </div>
        </div>
        <div class="content tx-13">
            <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
                <div class="row">
                    <div class="col-sm-6">

                        <h6 class="tx-15 mg-b-10"></h6>
                        <p class="mg-b-0">Responsável:</p>
                        <p class="mg-b-0">Email: </p>
                    </div><!-- col -->
                    <div class="col-sm-6 tx-right d-none d-md-block">
                        <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Proposta
                            número</label>
                        <h1 class="tx-normal tx-color-04 mg-b-10 tx-spacing--2">#{{$proposta->id}}</h1>
                    </div><!-- col -->
                </div><!-- row -->
                <div class="conteudo">
                    <div class="table-responsive mg-t-40">

                        @foreach($categoriaSoftware as $categoria)
                        <table id="tbl1" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Quantidades</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 2, 'basic') as $key=>$val)
                                    @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                    $totalDeVagas) != 0)
                                        <tr>
                                            <td>{{$val['nome']}}</td>
                                            <td>

                                                @if($val['preco']==0)
                                                R$ {!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}
                                                @else
                                                R$ {!! Helper::moedaReal($val['preco']) !!}
                                                @endif


                                                @if($val['preco']==0)
                                                <input type="hidden" class="valor"
                                                    value="{!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}" />
                                                @else
                                                <input type="hidden" class="valor" value="{{ $val['preco'] }}" />
                                                @endif
                                            </td>
                                            <td class="tx-center">

                                                {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                                $proposta->id, $totalDeVagas) !!}

                                                @if($val['unidade'] !== '')
                                                {{$val['unidade']}}
                                                @endif

                                                <input type="hidden" class="quantidade"
                                                    value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta->id, $totalDeVagas) !!}" />
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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Sub Total: </td>
                                </tr>
                            </tfoot>

                        </table>
                        @endforeach
                
                        @foreach($categoriaHardwarePrincipal as $categoria)
                        <table id="tbl2" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Quantidades</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 4, 'basic') as $key=>$val)
                                    @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                    $totalDeVagas) != 0)
                                    <tr>
                                        <td>{{$val['nome']}}</td>
                                        <td>
                                            @if($val['preco']==0)
                                            @if($val['variavel_id'] == 53 OR $val['variavel_id'] == 57)
                                            @php $var = "Cameras+"; @endphp
                                            @elseif($val['variavel_id'] == 54)
                                            @php $var = "Caixas Secundárias"; @endphp
                                            @else
                                            @php $var = "Licenças"; @endphp
                                            @endif
                                            R$ {!! Helper::valorPorVaga($totalDeVagas, $var, $val['sub_fixo_id']); !!}
                                            @else
                                            R$ {!! Helper::moedaReal($val['preco']) !!}
                                            @endif

                                            @if($val['preco']==0)

                                            @if($val['variavel_id'] == 53 OR $val['variavel_id'] == 57)
                                            @php $var = "Cameras+"; @endphp
                                            @elseif($val['variavel_id'] == 54)
                                            @php $var = "Caixas Secundárias"; @endphp
                                            @else
                                            @php $var = "Licenças"; @endphp
                                            @endif
                                            <input type="hidden" class="valor"
                                                value="{!! Helper::valorPorVaga($totalDeVagas, $var, $val['sub_fixo_id']); !!}" />
                                            @else
                                            <input type="hidden" class="valor" value="{{$val['preco']}}" />
                                            @endif
                                        </td>
                                        <td class="tx-center">
                                            {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                            $proposta->id, $totalDeVagas) !!}

                                            @if($val['unidade'] !== '')
                                            {{$val['unidade']}}
                                            @endif

                                            <input type="hidden" class="quantidade"
                                                value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta->id, $totalDeVagas) !!}" />
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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Total: </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endforeach

                        @foreach($categoriaHardwareNacional as $categoria)
                        <table id="tbl3" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Quantidades</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 5, 'basic') as $key=>$val)
                                @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                $totalDeVagas) != 0)
                                <tr>
                                    <td>{{$val['nome']}}</td>
                                    <td>
                                        @if($val['preco']==0)
                                        R$ {!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}
                                        @else
                                        R$ {!! Helper::moedaReal($val['preco']) !!}
                                        @endif
                                        <input type="hidden" class="valor" value="{{$val['preco']}}" />
                                    </td>
                                    <td class="tx-center">
                                        {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                        $proposta->id, $totalDeVagas) !!}

                                        <input type="hidden" class="quantidade"
                                            value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta->id, $totalDeVagas) !!}" />

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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Total: </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endforeach

              
                        @foreach($categoriaInstalacaoCompleta as $categoria)
                        <table id="tbl4" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Quantidades</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 6, 'basic') as $key=>$val)
                                @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                $totalDeVagas) != 0)
                                <tr>
                                    <td>{{$val['nome']}}</td>
                                    <td>
                                        @if($val['preco']==0)
                                        R$ {!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}
                                        @else
                                        R$ {!! Helper::moedaReal($val['preco']) !!}
                                        @endif
                                        <input type="hidden" class="valor" value="{{$val['preco']}}" />
                                    </td>
                                    <td class="tx-center">
                                        {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                        $proposta->id, $totalDeVagas) !!}

                                        <input type="hidden" class="quantidade"
                                            value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta->id, $totalDeVagas) !!}" />

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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Total: </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endforeach


                        @foreach($categoriaParkEyesHWPrincipal as $categoria)
                        <table id="tbl5" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Quantidades</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 8, 'basic') as $key=>$val)
                                @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                $totalDeVagas) != 0)
                                <tr>
                                    <td>{{$val['nome']}}</td>
                                    <td>
                                        @if($val['preco']==0)
                                        R$ {!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}
                                        @else
                                        R$ {!! Helper::moedaReal($val['preco']) !!}
                                        @endif
                                        <input type="hidden" class="valor" value="{{$val['preco']}}" />
                                    </td>
                                    <td class="tx-center">
                                        {!! Helper::regraDeNegocio($val['regra_de_negocio'],
                                        $val['variavel_id'],$proposta->id, $totalDeVagas) !!}

                                        <input type="hidden" class="quantidade"
                                            value="{!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'], $proposta->id, $totalDeVagas) !!}" />

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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Total: </td>
                                </tr>
                            </tfoot>

                        </table>
                        @endforeach

               
                        @foreach($categoriaParkEyesCompleta as $categoria)
                        <table id="tbl6" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Quantidades</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 10, 'basic') as $key=>$val)
                                @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                $totalDeVagas) != 0)
                                <tr>
                                    <td>{{$val['nome']}}</td>
                                    <td>
                                        @if($val['preco']==0)
                                        R$ {!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}
                                        @else
                                        R$ {!! Helper::moedaReal($val['preco']) !!}
                                        @endif </td>
                                    <td class="tx-center">
                                        {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                        $proposta->id, $totalDeVagas) !!}
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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Total: </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endforeach

            
                        @foreach($categoriaIntegracaoAplicativos as $categoria)
                        <table id="tbl7" class="table table-dark table-hover table-striped mg-b-0 somarTabela">
                            <thead>
                                <tr>
                                    <th class="wd-40p">{{$categoria->nome}}</th>
                                    <th class="wd-20p">Preços</th>
                                    <th class="tx-center">Incluir</th>
                                    <th class="tx-right">Projeto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::retornaVariaveis($proposta->cliente_id, 11, 'basic') as $key=>$val)
                                @if(Helper::regraDeNegocio($val['regra_de_negocio'],$val['variavel_id'], $proposta->id,
                                $totalDeVagas) != 0)
                                <tr>
                                    <td>{{$val['nome']}}</td>
                                    <td>
                                        @if($val['preco']==0)
                                        R$ {!! Helper::valorPorVaga($totalDeVagas, 'Licenças', $val['sub_fixo_id']); !!}
                                        @else
                                        R$ {!! Helper::moedaReal($val['preco']) !!}
                                        @endif </td>
                                    <td class="tx-center">
                                        {!! Helper::regraDeNegocio($val['regra_de_negocio'], $val['variavel_id'],
                                        $proposta->id, $totalDeVagas) !!}
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
                                    <td></td>
                                    <td class="tx-right valorTotalDoGrupo">Total: </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div><!-- row -->

        </div><!-- container -->
    </div>
</form>
@endsection


@section('js')

<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('js/dashforge.js')}}"></script>

<!-- append theme customizer -->
<script src="{{asset('lib/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('lib/jquery.maskMoney/jquery.maskMoney.js')}}" type="text/javascript"></script>

<script>
    $(document).ready(function () {
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
        var vTotalTb5 = 0;
        var vTotalTb6 = 0;
        var vTotalTb7 = 0;
       
        $('#tbl1 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb1 += parseFloat(valor);
        });


        $('#tbl2 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb2 += parseFloat(valor);
        });

        $('#tbl3 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb3 += parseFloat(valor);
        });

        $('#tbl4 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb4 += parseFloat(valor);
        });

        $('#tbl5 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb5 += parseFloat(valor);
        });

        $('#tbl6 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb6 += parseFloat(valor);
        });


        $('#tbl7 tbody tr td:last-child input').each(function(){
                valor   = parseFloat($(this).val()) || 0;
                console.log(valor);
                vTotalTb7 += parseFloat(valor);
        });
        $("#tbl1").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb1) + "</strong>");
        $("#tbl2").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb2) + "</strong>");
        $("#tbl3").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb3) + "</strong>");
        $("#tbl4").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb4) + "</strong>");
        $("#tbl5").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb5) + "</strong>");
        $("#tbl6").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb6) + "</strong>");
        $("#tbl7").find(".valorTotalDoGrupo").html("<strong>Subtotal - R$ " +formatMoney(vTotalTb7) + "</strong>");
    });
   

  

    $("#gerarProposta").click(function(){
        var conteudo = $(".conteudo").html();
        $(".textoCompleto").text(conteudo);
    });
    

   /* $('.somarTabela tr').each(function(){
        var total = 0;
        var total       = $(this).find('.total').val() || 0;
        var valorTotal  = formatMoney(total);
        $(this).find('.total').val(valorTotal);
    });*/

});    

function formatMoney(n, c, d, t) {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

</script>

@endsection