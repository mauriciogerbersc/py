<?php

namespace App\Helpers;

use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\VariaveisController;
use App\Http\Controllers\PropostasController;
use App\Http\Controllers\VagasController;
use App\Http\Controllers\VariaveisCategoriasController;
use App\PropostasRespostas;
use App\SubFixos;
use App\Proposta;

class Helper
{

    public static function categoriaPergunta($id_categoria)
    {
        $arr = array(1 => "Informações do Estabelecimento",   2 => "Estrutura do Estabelcimento", 3 => "Find Your Car");
        return $arr[$id_categoria];
    }


    public static function tipoDeCampo($id_campo)
    {
        $arr = array(1 => "Texto Simples",   2 => "Texto Longo", 3 => "Campo de Seleção", 4 => "Numeral");
        return $arr[$id_campo];
    }

    public static function retornaRespostas($pergunta_id)
    {
        $respostas = new ConfiguracaoController();
        return $respostas->retornoResposta($pergunta_id);
    }

    public static function procuraRespostas($pergunta_id, $proposta_id)
    {
        $respostas = new ConfiguracaoController();
        return $respostas->procuraRespostas($pergunta_id, $proposta_id);
    }

    public static function matheval($equation)
    {
        $equation = preg_replace("/[^0-9+\-.*\/()%]/", "", $equation);
        // fix percentage calcul when percentage value < 10 
        $equation = preg_replace("/([+-])([0-9]{1})(%)/", "*(1\$1.0\$2)", $equation);
        // calc percentage 
        $equation = preg_replace("/([+-])([0-9]+)(%)/", "*(1\$1.\$2)", $equation);
        // you could use str_replace on this next line 
        // if you really, really want to fine-tune this equation 
        $equation = preg_replace("/([0-9]+)(%)/", ".\$1", $equation);

        if ($equation == "") {
            $return = 0;
        } else {
            eval("\$return=" . $equation . ";");
        }

        return ceil($return);
    }

    public static function quantidadeParquesOutdoor($proposta_id){
        $parkesOutdoor = new ConfiguracaoController();
        $quantidade = $parkesOutdoor->quantidadeParquesOutdoor($proposta_id);
        return $quantidade;
    }

    public static function retornaPropostasClientes($cliente_id){
        #echo $cliente_id;
        $propostas = Proposta::where('propostas.cliente_id', '=', $cliente_id)
        ->join('users', 'users.id', 'propostas.cliente_id')
        ->join('tabela_precos_proposta', 'tabela_precos_proposta.proposta_id', '=', 'propostas.id')
        ->join('sub_fixos', 'sub_fixos.id', '=', 'tabela_precos_proposta.sub_fixos_id')
        ->select('users.name as nomeCliente', 'propostas.tp_proposta', 'propostas.id', 'propostas.created_at', 'propostas.status', 'sub_fixos.id as sub_id', 'sub_fixos.nomeSub')
        ->orderBy('propostas.id', 'desc')
        ->get();
        
        
        return $propostas;
    }
    public static function retornaAnteriores($id_pai){
        $subFixos = SubFixos::where('id', '=', $id_pai)
                              ->orWhere('tabela_pai', '=', $id_pai)
                              ->orderBy('created_at', 'desc')->get();
        return $subFixos;
    }

    public static function regraDeNegocio($regra, $variavel_id, $proposta_id, $totalDeVagas)
    {

        //echo $regra .  ' ' . $variavel_id .  ' ' . $proposta_id .  ' ' . $totalDeVagas . "<br>"; 

        if (strpos($regra, "[[") !== false) {
            $regra = str_replace("[[", "{{", $regra);
            if (strpos($regra, "]]") !== false) {
                $regra = str_replace("]]", "}}", $regra);
            }
        }

        if ((strpos($regra, "tbl") !== false) and (strpos($regra, "field"))) {

            if (preg_match_all("/(\{\{(tbl|field)\=)(?<conteudo>.{1,30})(\}\})(.[ ]?([0-9]*[.])?[0-9]{1,3})?/i", $regra, $out)) {


                $tabela = $out['conteudo'][0];
                $field  = $out['conteudo'][1];
                #echo "tbl {$tabela} field {$field} <br>";

                $total = 0;

                if ($field == 'countParaCisco') {
                    $estruturas = new ConfiguracaoController();
                    $total = $estruturas->totalParquesCobertos($tabela, $proposta_id);
                
                     #echo $totalDeVagas . "<br>";
                     if (!empty($out[5][1])) {
                        
                        $total = $total.$out[5][1];
                        #echo $total."<br>";
                        $total = Helper::matheval($total);
                    }
                    return $total;

                } elseif ($field == 'alturaEstrutura') {

                    $estruturas = new ConfiguracaoController();
                    $totalDistancias = $estruturas->distanciaEntreParques($proposta_id, $totalDeVagas, $field);

                    #echo $totalDeVagas . "<br>";
                    if (!empty($out[5][1])) {
                        $total = "$totalDeVagas" . "*" . $totalDistancias . $out[5][1];
                        #echo $total."<br>";
                        return Helper::matheval($total);
                    }
                } elseif ($field == 'distanciaCabeamentosCat5e') {

                    $estruturas = new ConfiguracaoController();
                    $totalDistancias = $estruturas->distanciaEntreParques($proposta_id, $totalDeVagas, $field);
                    return $totalDistancias;
                } else if ($field == 'distanciaEntreParques') {
                    $estruturas = new ConfiguracaoController();
                    $total = $estruturas->distanciaEntreParques($proposta_id, $totalDeVagas, $field);
                    return $total;
                } else if($field == 'distanciaEntreParquesAcessos') {
                    $estruturas = new ConfiguracaoController();
                    $total = $estruturas->distanciaEntreParques($proposta_id, $totalDeVagas, $field);
                    return $total;
                } else if ($field == 'distanciaEntreTodosParques') {
                    $estruturas = new ConfiguracaoController();
                    $total = $estruturas->distanciaEntreParques($proposta_id, $totalDeVagas, $field);
                    return $total;
                }else if($field == 'entradasSaidasLoops'){
                    $tipo = "loops";
                    $propostasRespostas = new ConfiguracaoController();
                    $total = $propostasRespostas->qtdEntradasSaidas($proposta_id,$tipo);
                    return $total;
                }else if($field == 'entradasSaidasDetectorLoops'){
                    $tipo = "detectorLoops";
                    $propostasRespostas = new ConfiguracaoController();
                    $total = $propostasRespostas->qtdEntradasSaidas($proposta_id,$tipo);
                    if (!empty($out[5][1])) {
                        $total = $total . $out[5][1];
                    }
                    return Helper::matheval($total);
                }


                $acessos = new ConfiguracaoController();
                $total = $acessos->subRegrasDaProposta($tabela, $field, $proposta_id);

                if (!empty($out[5][1])) {
                    $total = $total . $out[5][1];
                }

                return  Helper::matheval($total);
            }
        }

        if (strpos($regra, "{{variavel}}") !== false) {
          
            $valorQuestionario = new ConfiguracaoController();
            $valor = $valorQuestionario->valorQuestionario($variavel_id, $proposta_id, $field = null);
          
            $variaveis = array(26, 57, 55, 56, 51, 62, 63);
            $variaveisLPR = array(9,34);

            if (in_array($variavel_id, $variaveis)) {
            
                $valor = $valorQuestionario->valorQuestionario($variavel_id, $proposta_id, 'quantidadeCamerasExtras');
            } else if (in_array($variavel_id, $variaveisLPR)) {
                #echo __LINE__ ." <br> $variavel_id <br>";
                $valor = $valorQuestionario->valorQuestionario($variavel_id, $proposta_id, 'quantidadeCamerasLPR');
            }

            $regra = str_replace("{{variavel}}", $valor, $regra);
        }

        if (strpos($regra, "{{totalDeVagas}}") !== false) {
            $vagas = new VagasController();
            $totalDeVagas = $vagas->totalDeVagas($proposta_id);
            $regra = str_replace("{{totalDeVagas}}", $totalDeVagas['totalDeVagas'], $regra);
        }

        if (strpos($regra, "{{totalDeVagasInternas}}") !== false) {
            $vagas = new VagasController();
            $totalDeVagas = $vagas->totalDeVagas($proposta_id);
            $regra = str_replace("{{totalDeVagasInternas}}", $totalDeVagas['totalDeVagasInternas'], $regra);
        }


        if (preg_match("/[(.+)]/", $regra)) {
            return Helper::matheval($regra);
        }

        return ceil($regra);
    }

    public static function retornaPai($idPai)
    {
        $tabelas = new VariaveisCategoriasController();
        return $tabelas->retornaPai($idPai);
    }

    public static function retornaPropostaCliente($campo, $proposta_id)
    {
        $propostas = new PropostasController();
        return $propostas->retornaValorPropostaCliente($campo, $proposta_id);
    }

    public static function valorPorVaga($totalDeVagas, $tipo, $sub_fixo_id)
    {
        $propostas = new PropostasController();
        return $propostas->retornaValor($totalDeVagas, $tipo, $sub_fixo_id);
    }

    public static function retornaVariaveis($cliente_id, $categoria_id, $tipo, $proposta_id)
    {
        $variaveis = new VariaveisController();
        return $variaveis->retornaVariaveisCliente($cliente_id, $categoria_id, $tipo, $proposta_id);
    }


    public static function estadosComPropostas(){
        $proposta = Proposta::select('uf')->groupBy('uf')->get();

        $ufs = array();
        foreach($proposta as $k=>$v){
            $ufs[] = $v['uf'];
        }

        return $ufs;
    }

    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    /*
    Transforma o valor em R$ para formato do banco de dados 
    */
    public static function moedaDolar($get_valor)
    {

        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

    /*
    Transforma o valor do banco de dados em formato R$ 
    */
    public static function moedaReal($valor)
    {

        $valor = number_format($valor, 2, ',', '.');
        return $valor;
    }

    public static function formataDataHora($data)
    {

        return date("d/m/Y H:i", strtotime($data));
    }


    public static function  brl2decimal($brl)
    {
        $brl = str_replace(',', '.', str_replace('.', '', $brl));
        return $brl;
    }
}
