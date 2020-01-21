<?php

namespace App\Helpers;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\VariaveisController;
use App\Http\Controllers\PropostasController;
use App\Http\Controllers\VagasController;

class Helper
{

    public static function categoriaPergunta($id_categoria){
        $arr = array( 1 => "Informações do Estabelecimento",   2 => "Estrutura do Estabelcimento", 3 => "Find Your Car");
        return $arr[$id_categoria];
    }


    public static function tipoDeCampo($id_campo){
        $arr = array( 1 => "Texto Simples",   2 => "Texto Longo", 3 => "Campo de Seleção", 4 => "Numeral");
        return $arr[$id_campo];
    }

    public static function retornaRespostas($pergunta_id){
        $respostas = new ConfiguracaoController();
        return $respostas->retornoResposta($pergunta_id);
    }


    public static function matheval($equation) 
    {
        $equation = preg_replace("/[^0-9+\-.*\/()%]/","",$equation); 
        // fix percentage calcul when percentage value < 10 
        $equation = preg_replace("/([+-])([0-9]{1})(%)/","*(1\$1.0\$2)",$equation); 
        // calc percentage 
        $equation = preg_replace("/([+-])([0-9]+)(%)/","*(1\$1.\$2)",$equation); 
        // you could use str_replace on this next line 
        // if you really, really want to fine-tune this equation 
        $equation = preg_replace("/([0-9]+)(%)/",".\$1",$equation); 

        if ( $equation == "" ) {
            $return = 0; 
        } else { 
            eval("\$return=" . $equation . ";" ); 
        }

        return ceil($return); 
    }

    public static function regraDeNegocio($regra, $variavel_id, $proposta_id){
      
        if(strpos($regra, "[[") !== false){
            $regra = str_replace("[[", "{{", $regra);
            if(strpos($regra, "]]") !== false){
                $regra = str_replace("]]", "}}", $regra);
            }
        }
        
        if((strpos($regra, "tbl")!== false) AND (strpos($regra,"field"))){
            
            if(preg_match_all("/(\{\{(tbl|field)\=)(?<conteudo>.{1,20})(\}\})(.[ ]?([0-9]+([.][0-9]*)?|[.][0-9]+))?/i", $regra, $out)){
                
                $tabela = $out['conteudo'][0];
                $field  = $out['conteudo'][1];
                
                if($field == 'count'){
                    $estruturas = new ConfiguracaoController();
                    $total = $estruturas->totalParques($tabela,$proposta_id);
           
                    return $total*2 . " Un ";
                }elseif($field == 'altura'){
                    $estruturas = new ConfiguracaoController();
                    $distanciaEntreParques = $estruturas->distanciaEntreParques($proposta_id);
                }

                $acessos = new ConfiguracaoController();
                $total = $acessos->subRegrasDaProposta($tabela, $field, $proposta_id);
                
                if(!empty($out[5][1])){
                    $total = $total . $out[5][1];
                }

                return  Helper::matheval($total);
            }
        }

        if(strpos($regra, "{{variavel}}") !== false){
            
            $valorQuestionario = new ConfiguracaoController();
            $valor = $valorQuestionario->valorQuestionario($variavel_id, $proposta_id, $field = null);
       
            $variaveis = array(26, 57, 55, 56);
            if(in_array($variavel_id, $variaveis)){
     
                if(($variavel_id == 26) or ($variavel_id == 57) or ($variavel_id = 55) or ($variavel_id = 55)){
                    $valor = $valorQuestionario->valorQuestionario($variavel_id, $proposta_id, 'quantidadeCamerasExtras');
                }
            }

            $regra = str_replace("{{variavel}}", $valor, $regra);

          
        }

        if(strpos($regra, "{{totalDeVagas}}") !== false){
            $vagas = new VagasController();
            $totalDeVagas = $vagas->totalDeVagas($proposta_id);
            $regra = str_replace("{{totalDeVagas}}", $totalDeVagas, $regra);
        }

        
        if(preg_match("/[(.+)]/", $regra)){
            return Helper::matheval($regra);
        }
        return ceil($regra);
    }

    public static function retornaPropostaCliente($campo, $proposta_id){
        $propostas = new PropostasController();
        return $propostas->retornaValorPropostaCliente($campo, $proposta_id);
    }

    public static function valorPorVaga($totalDeVagas, $tipo, $sub_fixo_id){
        $propostas = new PropostasController();
        return $propostas->retornaValor($totalDeVagas, $tipo, $sub_fixo_id);
    }

    public static function retornaVariaveis($cliente_id, $categoria_id){
        $variaveis = new VariaveisController();
        return $variaveis->retornaVariaveisCliente($cliente_id, $categoria_id);
    }

    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    /*
    Transforma o valor em R$ para formato do banco de dados 
    */
    public static function moedaDolar($get_valor) {

        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

    /*
    Transforma o valor do banco de dados em formato R$ 
    */
    public static function moedaReal($valor) {

        $valor = number_format($valor, 2, ',', '.');
        return $valor;
    }

    public static function formataDataHora($data){
      
        return date("d/m/Y H:i", strtotime($data));
        
    }


    public static function  brl2decimal($brl) {
        $brl = str_replace(',', '.', str_replace('.', '', $brl));
        return $brl;
    }
}