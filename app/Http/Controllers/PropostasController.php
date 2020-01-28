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
// This is important to add here. 
use PDF;
use Helper;

class PropostasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index($id = null)
    {
        $propostas = Proposta::join('users', 'users.id', 'propostas.cliente_id')
                    ->select('users.name as nomeCliente', 'propostas.id', 'propostas.created_at')
                    ->get();
        
     
        if ($id != null) {
            $propostas = Proposta::where('cliente_id', '=', $id)
                                ->join('users', 'users.id', 'propostas.cliente_id')
                                ->select('users.name as nomeCliente', 'propostas.id', 'propostas.created_at')
                                ->get();
        }

        return view('propostas/index', compact('propostas'));
    }


    public function createOld($id)
    {

        $cliente       = User::find($id);

        if (isset($cliente)) {
            return view('propostas/cadastro', compact('cliente'));
        } else {
            return view('propostas/index');
        }
    }

    public function create($id)
    {

        $cliente       = User::find($id);

        $perguntas     = Perguntas::where('perguntas.id', '<>', 999)->get();

        return view('propostas/cadastroNovo', compact('cliente', 'perguntas'));
    }


    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function gerarProposta($id)
    {
        /* Recupero a proposta do cliente */
        $proposta       = Proposta::find($id);


        $categoriaSoftware                  = Categoria::where('id', '=', 2)->get();
        $categoriaHardwarePrincipal         = Categoria::where('id', '=', 4)->get();
        $categoriaHardwareNacional          = Categoria::where('id', '=', 5)->get();
        $categoriaInstalacaoCompleta        = Categoria::where('id', '=', 6)->get();
        $categoriaParkEyesSoftware          = Categoria::where('id', '=', 7)->get();
        $categoriaParkEyesHWPrincipal       = Categoria::where('id', '=', 8)->get();
        $categoriaParkEyesHWNacional        = Categoria::where('id', '=', 9)->get();
        $categoriaParkEyesCompleta          = Categoria::where('id', '=', 10)->get();
        $categoriaIntegracaoAplicativos     = Categoria::where('id', '=', 11)->get();

        $estrutura      = Estrutura::where('proposta_id', $id)->get();
        $totalDeVagas = 0;
        $vagasDescobertas = 0;
        foreach ($estrutura as $key => $total) {
            $totalDeVagas       += $total['qtdVagasInternas'] + $total['qtdVagasExternas'];
            $vagasDescobertas   += $total['qtdVagasExternas'];
        }



        $pdf = PDF::loadView('/propostas/pdf',  compact(
            'categoriaSoftware',
            'categoriaHardwarePrincipal',
            'categoriaHardwareNacional',
            'categoriaParkEyesSoftware',
            'categoriaParkEyesHWPrincipal',
            'categoriaParkEyesHWNacional',
            'categoriaParkEyesCompleta',
            'categoriaIntegracaoAplicativos',
            'proposta',
            'categoriaInstalacaoCompleta',
            'totalDeVagas',
            'vagasDescobertas'
        ));

        return $pdf->stream('document.pdf');
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
            $parqueCentralizado             = (isset($_POST['parqueMaisCentralizado'][$chave])) ? 1 : 0;
            $estrutura->nomeParque          = $valor;
            $estrutura->qtdVagasInternas    = $_POST['quantidadeVagasInternas'][$chave];
            $estrutura->qtdVagasExternas    = $_POST['quantidadeVagasExternas'][$chave];
            $estrutura->alturaSistema       = $_POST['alturaSistema'][$chave];
            $estrutura->alturaPeDireito     = $_POST['peDireito'][$chave];
            $estrutura->parqueCentralizado  = $_POST['parqueMaisCentralizado'][$chave];
            $estrutura->proposta_id         = $proposta_id;
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

        return redirect('/propostas')->with('classe', 'alert-success')->with('mensagem', 'Proposta cadastrada com sucesso.');;
    }

    public function showBasic($id){
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

        /* Recupero a proposta do cliente */
        $proposta       = Proposta::find($id);


        $estrutura          = Estrutura::where('proposta_id', $id)->get();
        $totalDeVagas       = 0;
        $vagasDescobertas   = 0;
        $vagasInternas      = 0;
        foreach ($estrutura as $key => $total) {
            $totalDeVagas       += $total['qtdVagasInternas'] + $total['qtdVagasExternas'];
            $vagasDescobertas   += $total['qtdVagasExternas'];
            $vagasInternas      += $total['qtdVagasInternas'];
        }

        return view(
            'propostas/visualizarBasic',
            compact(
                'categoriaSoftware',
                'categoriaHardwarePrincipal',
                'categoriaHardwareNacional',
                'categoriaParkEyesSoftware',
                'categoriaParkEyesHWPrincipal',
                'categoriaParkEyesHWNacional',
                'categoriaParkEyesCompleta',
                'categoriaIntegracaoAplicativos',
                'proposta',
                'categoriaInstalacaoCompleta',
                'totalDeVagas',
                'vagasDescobertas',
                'vagasInternas'
            )
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

        /* Recupero a proposta do cliente */
        $prop       = Proposta::where('propostas.id', '=', $id)
                    ->join('propostas_respostas', 'propostas_respostas.proposta_id', 'propostas.id')
                    ->select(   'propostas.cliente_id',
                                'propostas.created_at',
                                'propostas_respostas.proposta_id', 
                                'propostas_respostas.campo', 
                                'propostas_respostas.valor' )
                    ->get();

        $proposta = array();
        foreach($prop as $key=>$val){
            $proposta['created_at'] = $val['created_at'];
            $proposta['id']         = $val['proposta_id'];
            $proposta['cliente_id'] = $val['cliente_id'];
            if($val['campo']    ==  'estabelecimento'){
                $proposta['estabelecimento']    = $val['valor'];
            }

            if($val['campo']    ==  'responsavel'){
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
    
        return view(
            'propostas/visualizar',
            compact(
                'categoriaSoftware',
                'categoriaHardwarePrincipal',
                'categoriaHardwareNacional',
                'categoriaParkEyesSoftware',
                'categoriaParkEyesHWPrincipal',
                'categoriaParkEyesHWNacional',
                'categoriaParkEyesCompleta',
                'categoriaIntegracaoAplicativos',
                'proposta',
                'categoriaInstalacaoCompleta',
                'totalDeVagas',
                'vagasDescobertas',
                'vagasInternas'
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
            $preco = $v['preco'];
        }

        if($subcategoria_nome == 'nobreak'){
            $preco = ceil(5*$totalVagas/1000);
            $preco = $preco*1200;
        }

        return $preco;
    }
}
