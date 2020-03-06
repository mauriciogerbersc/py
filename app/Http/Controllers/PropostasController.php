<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Proposta;
use App\Estrutura;
use App\Acesso;
use App\Categoria;
use App\Variavel;
use App\SubCategoriaVagas;
use App\SubFixos;
use App\SubPrecosFixos;
use App\Vagas;
use App\Perguntas;
use App\PropostasRespostas;
use App\TabelaPrecosPropostas;
// This is important to add here. 
use PDF;
use Helper;

class PropostasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function plantas($id)
    {   
        $titulo     = "Plantas do Projeto";
        $idProposta = $id;
        $proposta = Proposta::where('propostas.id', '=', $id)
            ->join('estruturas', 'estruturas.proposta_id', '=', 'propostas.id')
            ->select('estruturas.nomeParque', 'estruturas.imagem', 'estruturas.parqueCentralizado','estruturas.id as idEstrutura', 'estruturas.distanciaCentralizado', 'estruturas.distanciaEntreParques')
            ->get();

            
        return view('propostas/plantas', compact('proposta', 'idProposta', 'titulo'));
    }

    public function plantasUpload(Request $request, $id)
    {
        $id_proposta = $id;
    
      
        if($request->hasFile('patio')){
             foreach($request->file('patio') as $key=>$val){
             $name                     = $val->getClientOriginalName();
             $name_sem_extensao        = pathinfo($name, PATHINFO_FILENAME);
             $extension                = $val->getClientOriginalExtension();
             $fileNameToStore          = uniqid().'_'.time().'.'.$extension;
             $val->move(public_path().'/files/', $fileNameToStore);
             $data[$key] = $fileNameToStore;
             }
         }
 
     
         foreach($data as $key=>$val){
             $estrutura = Estrutura::find($key);
 
             $estrutura->imagem          = $val;
             $estrutura->save();
         }
 
         $redirect = "/propostas/plantas/".$id_proposta;
         return redirect($redirect)->with('classe', 'alert-info')->with('mensagem', 'Imagens enviadas com sucesso');
      
 
    }
    public function index($id = null)
    {   
        $titulo    = "Propostas";
        $propostas = Proposta::join('users', 'users.id', 'propostas.cliente_id')
            ->select('users.name as nomeCliente', 'propostas.cliente_id', 'propostas.tp_proposta', 'propostas.id', 'propostas.created_at', 'propostas.status')
            ->groupBy('propostas.cliente_id')
            ->orderBy('propostas.id', 'desc')
            ->get();


        if ($id != null) {
            $propostas = Proposta::where('cliente_id', '=', $id)
                ->join('users', 'users.id', 'propostas.cliente_id')
                ->select('users.name as nomeCliente', 'propostas.cliente_id', 'propostas.tp_proposta', 'propostas.id', 'propostas.created_at', 'propostas.status')
                ->groupBy('propostas.cliente_id')
                ->orderBy('propostas.id', 'desc')
                ->get();
        }


        return view('propostas/index', compact('propostas', 'titulo'));
    }


    public function regerar($id, $tipo)
    {
        $titulo  = "Regerar Proposta";
        if ($tipo == 'full') {
            $tipo_proposta = 0;
            $perguntas = Perguntas::where('perguntas.id', '<>', 999)
                ->where('tipo_proposta', '=', 1)
                ->orWhere('tipo_proposta', '=', 3)
                ->where('status', '=', 1)
                ->get();
            $isBasic       = false;
        } else {
            $tipo_proposta = 1;
            $perguntas     = Perguntas::where('perguntas.id', '<>', 999)
                ->where('tipo_proposta', '=', 3)
                ->where('status', '=', 1)
                ->get();
            $isBasic       = true;
        }

        $proposta_id        = $id;
        $propostasRespostas = PropostasRespostas::where('propostas_respostas.proposta_id', '=', $id)->first();
        $estruturas         = Estrutura::where('proposta_id', $id)->get();
        $proposta           = Proposta::find($id);

        $cliente_id         = $proposta['cliente_id'];


        return view(
            'propostas/regerar',
            compact(
                'estruturas',
                'cliente_id',
                'proposta',
                'isBasic',
                'perguntas',
                'propostasRespostas',
                'proposta_id',
                'tipo_proposta',
                'titulo'
            )
        );
    }


    public function create($id)
    {
        $titulo = "Gerar nova Proposta Full";
        $cliente       = User::find($id);
        $tipo_proposta = 0;
        $perguntas     = Perguntas::where('perguntas.id', '<>', 999)
            ->where('perguntas.tipo_proposta', '=', 1)
            ->orWhere('perguntas.tipo_proposta', '=', 3)
            ->where('perguntas.status', '=', 1)
            ->get();
        $tabelas       = SubFixos::where('status', '=', 1)->get();
        $isBasic       = false;
        return view('propostas/cadastroNovo', compact('cliente', 'perguntas', 'isBasic', 'tipo_proposta', 'tabelas', 'titulo'));
    }

    public function createBasic($id)
    {

        $titulo = "Gerar nova Proposta Basic";
        $cliente       = User::find($id);
        $tipo_proposta = 1;
        $perguntas     = Perguntas::where('perguntas.id', '<>', 999)
            ->where('tipo_proposta', '=', 3)
            ->where('status', '=', 1)
            ->get();

        $isBasic       = true;

        $tabelas       = SubFixos::where('status', '=', 1)->get();
        return view('propostas/cadastroNovo', compact('cliente', 'perguntas', 'isBasic', 'tipo_proposta', 'tabelas', 'titulo'));
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function gerarProposta($id)
    {
        $proposta = Proposta::find($id);

        $base64_decode  = base64_decode($proposta['conteudo_base64']);

        return view('propostas/pdf', compact('base64_decode'));
    }


    public function regerarNova(Request $request, $id)
    {


        $proposta = new Proposta();

        $proposta->cliente_id                = $request->input('cliente_id');
        $proposta->cep                       = $request->input('cep');
        $proposta->cidade                    = $request->input('cidade');
        $proposta->uf                        = $request->input('uf');
        $proposta->rua                       = $request->input('rua');
        $proposta->proposta_pai              = $id;
        $proposta->tp_proposta               = $request->input('tipo_proposta');
        $proposta->save();

        $proposta_id = $proposta->id;


        foreach ($request->input() as $key => $val) {
            if (!is_array($val)) {
                if (strpos($key, "_") !== false) {
                    if (($key != '_token') and ($key != 'cliente_id')) {
                        $proposta_respostas = new PropostasRespostas();
                        $exp = explode("_", $key);
                        $id_pergunta = $exp[1];
                        $campo_name  = $exp[0];
                        $proposta_respostas->pergunta_id = $id_pergunta;
                        $proposta_respostas->campo       = $campo_name;
                        $proposta_respostas->valor       = $request->input($key);
                        $proposta_respostas->proposta_id = $proposta_id;
                        $proposta_respostas->save();
                    }
                }
            }
        }

        foreach ($_POST['nomeParque'] as $chave => $valor) {
            $estrutura = new Estrutura();
            //$parqueCentralizado             = (isset($_POST['parqueMaisCentralizado'][$chave])) ? 1 : 0;
            $pkMaisCentralizado             = $_POST['parqueMaisCentralizado'][$chave];
            $estrutura->nomeParque          = $valor;
            $estrutura->qtdVagasInternas    = $_POST['quantidadeVagasInternas'][$chave];
            $estrutura->qtdVagasExternas    = $_POST['quantidadeVagasExternas'][$chave];
            $estrutura->alturaSistema       = $_POST['alturaSistema'][$chave];
            $estrutura->alturaPeDireito     = $_POST['peDireito'][$chave];
            $estrutura->parqueCentralizado  = $_POST['parqueMaisCentralizado'][$chave];
            $estrutura->proposta_id         = $proposta_id;
            if ($pkMaisCentralizado == 1) {
                $estrutura->distanciaCentralizado = $_POST['distanciaEntreParques'][$chave];
                $estrutura->distanciaEntreParques =  0;
            } else {
                $estrutura->distanciaCentralizado =  0;
                $estrutura->distanciaEntreParques =  $_POST['distanciaEntreParques'][$chave];
            }

            $estrutura->save();
        }


        for ($i = 0; $i <  $_POST['qtdAcessosExternos_11']; $i++) {
            $acesso = new Acesso();
            $acesso->nomeAcesso             = $_POST['nomeAcessoExterno'][$i];
            $acesso->qtdLinhasPaineis       = $_POST['quantidadeLinhasPaineis'][$i];
            $acesso->distanciaProximo       = $_POST['distanciaAcessoProximo'][$i];
            $acesso->proposta_id            = $proposta_id;
            $acesso->save();
        }


        return redirect('/propostas')->with('classe', 'alert-success')->with('mensagem', 'Proposta criada com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $proposta = new Proposta();

        $proposta->cliente_id                = $request->input('cliente_id');
        $proposta->cep                       = $request->input('cep');
        $proposta->cidade                    = $request->input('cidade');
        $proposta->uf                        = $request->input('uf');
        $proposta->rua                       = $request->input('rua');
        $proposta->tp_proposta               = $request->input('tipo_proposta');
        $proposta->save();

        $proposta_id = $proposta->id;


        /* Salvando o relacionamento da  tabela de preços utilizada, cliente e projeto. */
        $tabelaPrecosPropostas = new TabelaPrecosPropostas();
        $tabelaPrecosPropostas->cliente_id  = $request->input('cliente_id');
        $tabelaPrecosPropostas->proposta_id = $proposta_id;
        $tabelaPrecosPropostas->sub_fixos_id = $request->input('tabela_id');
        $tabelaPrecosPropostas->save();


        foreach ($request->input() as $key => $val) {
            if (!is_array($val)) {
                if (strpos($key, "_") !== false) {
                    if (($key != '_token') and ($key != 'cliente_id')) {
                        $proposta_respostas = new PropostasRespostas();
                        $exp = explode("_", $key);
                        $id_pergunta = $exp[1];
                        $campo_name  = $exp[0];
                        $proposta_respostas->pergunta_id = $id_pergunta;
                        $proposta_respostas->campo       = $campo_name;
                        $proposta_respostas->valor       = $request->input($key);
                        $proposta_respostas->proposta_id = $proposta_id;
                        $proposta_respostas->save();
                    }
                }
            }
        }



        foreach ($_POST['nomeParque'] as $chave => $valor) {
            $estrutura = new Estrutura();
            //$parqueCentralizado             = (isset($_POST['parqueMaisCentralizado'][$chave])) ? 1 : 0;
            $pkMaisCentralizado             = $_POST['parqueMaisCentralizado'][$chave];
            $estrutura->nomeParque          = $valor;
            $estrutura->qtdVagasInternas    = $_POST['quantidadeVagasInternas'][$chave];
            $estrutura->qtdVagasExternas    = $_POST['quantidadeVagasExternas'][$chave];
            $estrutura->alturaSistema       = $_POST['alturaSistema'][$chave];
            $estrutura->alturaPeDireito     = $_POST['peDireito'][$chave];
            $estrutura->parqueCentralizado  = $_POST['parqueMaisCentralizado'][$chave];
            $estrutura->proposta_id         = $proposta_id;
            if ($pkMaisCentralizado == 1) {
                $estrutura->distanciaCentralizado = $_POST['distanciaEntreParques'][$chave];
                $estrutura->distanciaEntreParques =  0;
            } else {
                $estrutura->distanciaCentralizado =  0;
                $estrutura->distanciaEntreParques =  $_POST['distanciaEntreParques'][$chave];
            }

            $estrutura->save();
        }


        /* foreach ($_POST['nomeParque'] as $chave => $valor) {
           
            if($chave !== $pkMaisCentralizado) {
                $estrutura->distanciaEntreParques = $_POST['distanciaEntreParques'][$chave];
                $estrutura->distanciaCentralizado = 0;   
            }else{
                $estrutura->distanciaCentralizado = $_POST['distanciaEntreParques'][$chave];
                $estrutura->distanciaEntreParques =  0;
            }
           
            $estrutura->save();
        }*/

        for ($i = 0; $i <  $_POST['qtdAcessosExternos_11']; $i++) {
            $acesso = new Acesso();
            $acesso->nomeAcesso             = $_POST['nomeAcessoExterno'][$i];
            $acesso->qtdLinhasPaineis       = $_POST['quantidadeLinhasPaineis'][$i];
            $acesso->distanciaProximo       = $_POST['distanciaAcessoProximo'][$i];
            $acesso->proposta_id            = $proposta_id;
            $acesso->save();
        }

        return redirect('/propostas')->with('classe', 'alert-success')->with('mensagem', 'Proposta criada com sucesso.');
    }

    public function showBasic($id)
    {

        $estruturaProposta = Proposta::where('propostas.id', '=', $id)
        ->join('estruturas', 'estruturas.proposta_id', '=', 'propostas.id')
        ->select('estruturas.nomeParque', 'estruturas.imagem', 'estruturas.parqueCentralizado','estruturas.id as idEstrutura', 'estruturas.distanciaCentralizado', 'estruturas.distanciaEntreParques')
        ->get();

        $titulo = "Proposta Basic";
        /* Todas as categorias dos tipos de produtos */
        $categoriaSoftware                  = Categoria::where('id', '=', 2)->get();
        $categoriaHardwarePrincipal         = Categoria::where('id', '=', 4)->get();
        $categoriaHardwareNacional          = Categoria::where('id', '=', 5)->get();
        $categoriaInstalacaoCompleta        = Categoria::where('id', '=', 6)->get();
        $categoriaParkEyesSoftware          = Categoria::where('id', '=', 7)->get();
        $categoriaParkEyesHWPrincipal       = Categoria::where('id', '=', 8)->get();
        $categoriaParkEyesHWNacional        = Categoria::where('id', '=', 9)->get();
        $categoriaParkEyesCompleta          = Categoria::where('id', '=', 10)->get();
        // $categoriaIntegracaoAplicativos     = Categoria::where('id', '=', 11)->get();

        /* Recupero a proposta do cliente */
        $prop       = Proposta::where('propostas.id', '=', $id)
            ->join('propostas_respostas', 'propostas_respostas.proposta_id', 'propostas.id')
            ->select(
                'propostas.cliente_id',
                'propostas.created_at',
                'propostas_respostas.proposta_id',
                'propostas_respostas.campo',
                'propostas_respostas.valor'
            )
            ->get();

        $proposta = array();
        foreach ($prop as $key => $val) {
            $proposta['created_at'] = $val['created_at'];
            $proposta['id']         = $val['proposta_id'];
            $proposta['cliente_id'] = $val['cliente_id'];
            if ($val['campo']    ==  'estabelecimento') {
                $proposta['estabelecimento']    = $val['valor'];
            }

            if ($val['campo']    ==  'responsavel') {
                $proposta['responsavel']        = $val['valor'];
            }
        }

        $estrutura      = Estrutura::where('proposta_id', $id)->get();
        $totalDeVagas       = 0;
        $vagasDescobertas   = 0;
        $vagasInternas      = 0;
        foreach ($estrutura as $key => $total) {
            $totalDeVagas       += $total['qtdVagasInternas'] + $total['qtdVagasExternas'];
            $vagasDescobertas   += $total['qtdVagasExternas'];
            $vagasInternas      += $total['qtdVagasInternas'];
        }

        $distanciaEntreParques = 0;
        foreach($estruturaProposta as $k=>$v){
            if($v['distanciaEntreParques']!=0){
                 $distanciaEntreParques = $v['distanciaEntreParques'];
            }
        }
    
        $totalDias = PropostasRespostas::where('campo', '=', 'qtdDiasDeGravacao')
            ->where('proposta_id', '=', $id)
            ->select('valor')
            ->first();

        $notas = PropostasRespostas::where('campo', '=', 'notasObservacoes')
        ->where('proposta_id', '=', $id)
        ->select('valor')
        ->first();

        $totalDiasGravacao = $totalDias->valor;
        if ($totalDiasGravacao == 0) {
            $totalDiasGravacao = "24h";
        }
        return view(
            'propostas/visualizarBasic',
            compact(
                'estruturaProposta',
                'categoriaSoftware',
                'categoriaHardwarePrincipal',
                'categoriaHardwareNacional',
                'categoriaParkEyesSoftware',
                'categoriaParkEyesHWPrincipal',
                'categoriaParkEyesHWNacional',
                'categoriaParkEyesCompleta',
                'proposta',
                'totalDiasGravacao',
                'categoriaInstalacaoCompleta',
                'totalDeVagas',
                'vagasDescobertas',
                'vagasInternas',
                'titulo',
                'distanciaEntreParques',
                'notas'
            )
        );
    }

    public function valorCampo()
    {
        return view('valorCampo');
    }

    public static function valorCampoPost(Request $request)
    {
        $input = $request->all();



        if ($input['tipo'] == 'distanciaCentralizado') {
            $var = Estrutura::where('proposta_id', '=', $request['proposta_id'])->select('distanciaCentralizado')->first();
            $distanciaCentralizado   =  $var->distanciaCentralizado;
            return response()->json(['success' => true, 'valor' => $distanciaCentralizado]);
        } elseif ($input['tipo'] == 'distanciaEntreParques') {
            $var = Estrutura::where('proposta_id', '=', $request['proposta_id'])->select('distanciaEntreParques')->first();
            $distanciaEntreParques   =  $var->distanciaEntreParques;
            return response()->json(['success' => true, 'valor' => $distanciaEntreParques]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function saveServerSide()
    {
        return view('saveServerSide');
    }

    public static function saveServerSidePost(Request $request)
    {

        $input = $request->all();
        $var = Proposta::find($input['propostaId']);
        $proposta_base64 = base64_encode($input['imageData']);
        if (isset($var)) {
            $var->status            = 1;
            $var->conteudo_base64   = $proposta_base64;
            $var->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


    public function atualizaStatus()
    {
        return view('atualizaStatus');
    }

    /*ajax*/
    public function atualizaStatusPost(Request $request)
    {
        $input = $request->all();

        $var = Proposta::find($input['propostaId']);
        if (isset($var)) {
            $var->status = 1;
            $var->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titulo = 'Proposta Full';
        $estruturaProposta = Proposta::where('propostas.id', '=', $id)
        ->join('estruturas', 'estruturas.proposta_id', '=', 'propostas.id')
        ->select('estruturas.nomeParque', 'estruturas.imagem', 'estruturas.parqueCentralizado','estruturas.id as idEstrutura', 'estruturas.distanciaCentralizado', 'estruturas.distanciaEntreParques')
        ->get();

        
        $notas = PropostasRespostas::where('campo', '=', 'notasObservacoes')
        ->where('proposta_id', '=', $id)
        ->select('valor')
        ->first();

        $qtdEntradas =  PropostasRespostas::where('campo', '=', 'qtdEntradas')
        ->where('proposta_id', '=', $id)
        ->select('valor')
        ->first();
    
        $qtdSaidas =  PropostasRespostas::where('campo', '=', 'qtdSaidas')
        ->where('proposta_id', '=', $id)
        ->select('valor')
        ->first();
        /* Todas as categorias dos tipos de produtos */
        $categoriaSoftware                  = Categoria::where('id', '=', 2)->get();
        $categoriaHardwarePrincipal         = Categoria::where('id', '=', 4)->get();
        $categoriaHardwareNacional          = Categoria::where('id', '=', 5)->get();
        $categoriaInstalacaoCompleta        = Categoria::where('id', '=', 6)->get();
        $categoriaParkEyesSoftware          = Categoria::where('id', '=', 7)->get();
        $categoriaParkEyesHWPrincipal       = Categoria::where('id', '=', 8)->get();
        $categoriaParkEyesHWNacional        = Categoria::where('id', '=', 9)->get();
        $categoriaParkEyesCompleta          = Categoria::where('id', '=', 10)->get();
        $categoriaIntegracaoAplicativos     = Categoria::where('id', '=', 11)->get();

        $distanciaEntreParques = 0;
       foreach($estruturaProposta as $k=>$v){
           if($v['distanciaEntreParques']!=0){
                $distanciaEntreParques = $v['distanciaEntreParques'];
           }
       }
   
        /* Recupero a proposta do cliente */
        $prop       = Proposta::where('propostas.id', '=', $id)
            ->join('propostas_respostas', 'propostas_respostas.proposta_id', 'propostas.id')
            ->select(
                'propostas.cliente_id',
                'propostas.created_at',
                'propostas_respostas.proposta_id',
                'propostas_respostas.campo',
                'propostas_respostas.valor'
            )
            ->get();

        $proposta = array();
        foreach ($prop as $key => $val) {
            $proposta['created_at'] = $val['created_at'];
            $proposta['id']         = $val['proposta_id'];
            $proposta['cliente_id'] = $val['cliente_id'];
            if ($val['campo']    ==  'estabelecimento') {
                $proposta['estabelecimento']    = $val['valor'];
            }

            if ($val['campo']    ==  'responsavel') {
                $proposta['responsavel']        = $val['valor'];
            }
        }

        $estrutura      = Estrutura::where('proposta_id', $id)->get();
        $totalDeVagas       = 0;
        $vagasDescobertas   = 0;
        $vagasInternas      = 0;
        foreach ($estrutura as $key => $total) {
            $totalDeVagas       += $total['qtdVagasInternas'] + $total['qtdVagasExternas'];
            $vagasDescobertas   += $total['qtdVagasExternas'];
            $vagasInternas      += $total['qtdVagasInternas'];
        }


        $totalDias = PropostasRespostas::where('campo', '=', 'qtdDiasDeGravacao')
            ->where('proposta_id', '=', $id)
            ->select('valor')
            ->first();

        $totalDiasGravacao = $totalDias->valor;
        if ($totalDiasGravacao == 0) {
            $totalDiasGravacao = "24h";
        } else {
            $totalDiasGravacao = $totalDiasGravacao . " dias";
        }

        return view(
            'propostas/visualizar',
            compact(
                'categoriaSoftware',
                'categoriaHardwarePrincipal',
                'categoriaHardwareNacional',
                'categoriaParkEyesSoftware',
                'estruturaProposta',
                'qtdEntradas',
                'qtdSaidas',
                'categoriaParkEyesHWPrincipal',
                'categoriaParkEyesHWNacional',
                'categoriaParkEyesCompleta',
                'categoriaIntegracaoAplicativos',
                'proposta',
                'notas',
                'distanciaEntreParques',
                'totalDiasGravacao',
                'categoriaInstalacaoCompleta',
                'totalDeVagas',
                'vagasDescobertas',
                'vagasInternas',
                'titulo'
            )
        );
    }

    public function valorVariavel($id, $cliente_id)
    {

        $dadosCliente = User::where('id', $cliente_id)->get();
        foreach ($dadosCliente as $key => $val) {
            $sub_fixo_id =  $val['sub_fixo_id'];
        }

        $fixo     = SubPrecosFixos::where('categoria_fixo_id', '=', $id)
            ->where('sub_fixo_id', '=', $sub_fixo_id)
            ->get();

        $valor = 0;
        foreach ($fixo as $v) {
            $valor = $v['preco'];
        }

        return $valor;
    }


    public function retornaValorPropostaCliente($campo, $proposta_id)
    {

        $retornaValor = PropostasRespostas::where('campo', '=', $campo)
            ->where('proposta_id', '=', $proposta_id)
            ->select('valor')
            ->get();
        // $valorCampo = "";
        foreach ($retornaValor as $k => $v) {
            $valorCampo = $v['valor'];
        }
        return $valorCampo;
    }

    public function retornaValor($totalVagas, $subcategoria_nome, $sub_fixo_id)
    {


        $procuraVaga = Vagas::where('minimoDaCategoria', '<=', $totalVagas)
            ->where('maximoDaCategoria', '>=', $totalVagas)
            ->where('subcategoria_nome', $subcategoria_nome)
            ->where('categorias_precos_fixos.sub_fixos_id', '=', $sub_fixo_id)
            ->join('categorias_precos_fixos', 'categorias_precos_fixos.vaga_id', 'vagas.id')
            ->join('sub_categoria_vagas', 'sub_categoria_vagas.id', 'categorias_precos_fixos.sub_categoria_id')
            ->select('categorias_precos_fixos.preco')
            ->get();


        foreach ($procuraVaga as $k => $v) {
            $preco =  number_format($v['preco'], 2, ',', '');
        }

        if ($subcategoria_nome == 'nobreak') {
            $preco = ceil(5 * $totalVagas / 1000);
            $preco = $preco * 1200;
        }

        return $preco;
    }
}
