<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perguntas;
use App\OpcoesPerguntas;
use App\Proposta;
use App\RegraPerguntaVariavel;
use App\Variavel;
use App\Estrutura;
use Helper;

class ConfiguracaoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $perguntas = Perguntas::all();
        return view('/configuracao/index', compact('perguntas'));
    }


    public function create()
    {

        return view('/configuracao/cadastroPergunta');
    }

    public function distanciaEntreParques($proposta_id){
      
        $estrutura = Estrutura::where('estruturas.proposta_id', '=', $proposta_id)
                                ->select('estruturas.alturaSistema',
                                 'estruturas.alturaPeDireito', 
                                 'estruturas.qtdVagasInternas', 
                                 'estruturas.qtdVagasExternas')
                                ->get();
     
        echo "<pre>";
        print_r($estrutura);
        exit;
        foreach($estrutura as $key=>$val){
            $diferencaCm = $val['alturaPeDireito'] - $val['alturaSistema'];
            echo $diferencaCm . "<br>";
        }

                    
    }

    public function totalParques($tabela, $proposta_id)
    {
        $estrutura = Estrutura::where('proposta_id', '=', $proposta_id)->count();
        return $estrutura;
    }

    public function subRegrasDaProposta($tabela, $field, $proposta_id)
    {
        
        $total = 0;

        if($tabela=='estruturas'){
            $proposta = Proposta::where('propostas.id', '=', $proposta_id)
            ->leftjoin('estruturas', 'estruturas.proposta_id', '=', 'propostas.id')
            ->select($tabela . "." . $field)
            ->get();
        }else{
            $proposta = Proposta::where('propostas.id', '=', $proposta_id)
            ->leftjoin('acessos', 'acessos.proposta_id', '=', 'propostas.id')
            ->select($tabela . "." . $field)
            ->get();
        }

        foreach ($proposta as $val) {
            $total += $val[$field];
        }

        return $total;
    }

    public function valorQuestionario($variavel_id, $proposta_id, $field)
    {

        if (!empty($field)) {
            $valor = RegraPerguntaVariavel::where('variavel_id', '=', $variavel_id)
                ->where('proposta_id', '=', $proposta_id)
                ->where('campo', '=', $field)
                ->join('propostas_respostas', 'propostas_respostas.pergunta_id', '=', 'regra_pergunta_variavels.pergunta_id')
                ->select('propostas_respostas.valor')
                ->take(1)
                ->first();
        } else {
          
            $valor = RegraPerguntaVariavel::where('variavel_id', '=', $variavel_id)
                ->where('proposta_id', '=', $proposta_id)
                ->join('propostas_respostas', 'propostas_respostas.pergunta_id', '=', 'regra_pergunta_variavels.pergunta_id')
                ->select('propostas_respostas.valor')
                ->take(1)
                ->first();
        }
  
        return $valor['valor'];
        
    }

    public function regras()
    {

        $regra = RegraPerguntaVariavel::join('variavels', 'variavels.id', '=', 'regra_pergunta_variavels.variavel_id')
            ->join('perguntas', 'perguntas.id', '=', 'regra_pergunta_variavels.pergunta_id')
            ->select('variavels.nome', 'perguntas.pergunta', 'regra_pergunta_variavels.id', 'regra_pergunta_variavels.regra_de_negocio')
            ->get();

        $regras = array();

        foreach ($regra as $val) {

            $regras[] = array(
                'pergunta' => $val->pergunta,
                'variavel' => $val->nome,
                'regra_de_negocio' => $val->regra_de_negocio,
                'id'        => $val->id
            );
        }
        return view('/configuracao/regras', compact('regras'));
    }

    public function criarRegra()
    {
        $perguntas = Perguntas::all();
        $variaveis = Variavel::orderBy('nome', 'asc')->get();
        return view('/configuracao/novaRegra', compact('perguntas', 'variaveis'));
    }


    public function salvarRegra(Request $request, $id)
    {
        $regra = RegraPerguntaVariavel::find($id);


        if (isset($regra)) {
            $regra->pergunta_id = $request->pergunta_id;
            $regra->variavel_id = $request->variavel_id;
            $regra->regra_de_negocio = $request->regra_negocio;
            $regra->save();
        } else {
            return redirect('configuracao/regras');
        }

        return redirect('configuracao/regras');
    }

    public function storeRegra(Request $request)
    {
        $regra = new RegraPerguntaVariavel();

        $regra->pergunta_id = $request->pergunta_id;
        $regra->variavel_id = $request->variavel_id;
        $regra->regra_de_negocio = $request->regra_negocio;
        $regra->save();

        return redirect('/configuracao/regras');
    }

    public function store(Request $request)
    {

        $rules = [
            'pergunta' => 'required'
        ];

        $messages = [
            'pergunta.required' => 'O campo Pergunta é obrigatório'
        ];

        $request->validate($rules, $messages);

        $pergunta                       = new Perguntas();
        $pergunta->categoria_id         = $request->input('categoria_id');
        $pergunta->campo_obrigatorio    = $request->input('campo_obrigatorio');
        $pergunta->pergunta             = $request->input('pergunta');
        $pergunta->tipo_campo           = $request->input('tipo_campo');
        $pergunta->tipo_proposta        = $request->input('tipo_proposta');
        $pergunta->id_campo             = $request->input('id_campo');
        $pergunta->name_campo           = $request->input('name_campo');
        $pergunta->html_apendice        = $request->input('html_apendice');

        $pergunta->save();

        $pergunta_id = $pergunta->id;

        if ($request->input('tipo_campo') == 3) {
            foreach ($_POST['opcao'] as $key => $val) {
                $opcoes_perguntas = new OpcoesPerguntas();
                $opcoes_perguntas->pergunta_id = $pergunta_id;
                $opcoes_perguntas->valor_pergunta = $val;
                $opcoes_perguntas->save();
            }
        }
        return redirect('/configuracao');
    }


    public function update(Request $request, $id)
    {

        $rules = [
            'pergunta' => 'required',
            'name_campo' => 'required'
        ];

        $messages = [
            'pergunta.required' => 'O campo Pergunta é obrigatório',
            'name_campo.required' => 'O campo NAME é obrigatório'
        ];

        $request->validate($rules, $messages);


        $pergunta = Perguntas::find($id);


        if (isset($pergunta)) {
            $pergunta->categoria_id         = $request->input('categoria_id');
            $pergunta->campo_obrigatorio    = $request->input('campo_obrigatorio');
            $pergunta->pergunta             = $request->input('pergunta');
            $pergunta->tipo_campo           = $request->input('tipo_campo');
            $pergunta->tipo_proposta        = $request->input('tipo_proposta');
            $pergunta->id_campo             = $request->input('id_campo');
            $pergunta->name_campo           = $request->input('name_campo');
            $pergunta->html_apendice        = $request->input('html_apendice');

            $pergunta->save();
        } else {
            return redirect('configuracao');
        }

        return redirect('configuracao');
    }


    public function edit($id)
    {
        $pergunta           = Perguntas::find($id);

        if (isset($pergunta)) {
            return view('/configuracao/editarPergunta', compact('pergunta'));
        } else {
            return view('/configuracao');
        }
    }

    public function editarRegra($id)
    {

        $perguntas = Perguntas::all();
        $variaveis = Variavel::all();

        $regra = RegraPerguntaVariavel::find($id);


        if (isset($regra)) {
            return view('/configuracao/editarRegra', compact('regra', 'perguntas', 'variaveis'));
        } else {
            redirect('/configuracao/regras');
        }
    }

    public function retornoResposta($id_pergunta)
    {

        $opcao = OpcoesPerguntas::where('pergunta_id', $id_pergunta)->get();

        $opcoes = array();
        foreach ($opcao as $key => $val) {
            $opcoes[] = array('id' => $val['id'], 'valor' => $val['valor_pergunta'], 'opcao_selecionada' => $val['opcao_selecionada']);
        }
        return $opcoes;
    }


    public function destroy($id)
    {
        $pergunta = Perguntas::find($id);
        if (isset($pergunta)) {
            $pergunta->delete();
        } else {
            return view('/configuracao');
        }
        return redirect('/configuracao');
    }
}