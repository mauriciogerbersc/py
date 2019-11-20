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
use App\Vagas;

class PropostasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');    
    }


    public function index(){
        $propostas = Proposta::orderBy('created_at','asc')->get();;
     
        return view('propostas/index', compact('propostas'));
    }

    public function create($id){

        $cliente       = User::find($id);
        if(isset($cliente)){
            return view('propostas/cadastro', compact('cliente'));
        }else{
            return view('propostas/index'); 
        }
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
 
     
        $proposta = new Proposta();

        $proposta->estabelecimento           = $request->input('estabelecimento');
        $proposta->responsavel               = $request->input('responsavel');
        $proposta->qtdDiasDeGravacao         = $request->input('qtdDiasDeGravacao');
        $proposta->possuiCamerasExtras       = $request->input('possuiCamerasExtras');
        $proposta->quantidadeCamerasExtras   = $request->input('quantidadeCamerasExtras');
        $proposta->quantosPaineisSinalizados = $request->input('quantosPaineisSinalizados');
        $proposta->distanciaCentroControle   = $request->input('distanciaCentroControle');
        $proposta->distanciaEntreParques     = $request->input('distanciaEntreParques');
        $proposta->qtdEntradas               = $request->input('qtdEntradas');
        $proposta->qtdSaidas                 = $request->input('qtdSaidas');
        $proposta->camerasExtrasLPR          = $request->input('camerasExtrasLPR'); // qdo acessa estacionamento externo
        $proposta->quantidadeCamerasExtrasLPR= $request->input('quantidadeCamerasExtrasLPR');
        $proposta->qtdAcessosExternos        = $request->input('qtdAcessosExternos');
        $proposta->camerasLPR                = $request->input('camerasLPR'); // quando um veículo acessa, ou sai das cancelas de seu estaciomento
        $proposta->quantidadeCamerasLPR      = $request->input('quantidadeCamerasLPR');
        $proposta->qtdTotensFindYorCar       = $request->input('qtdTotensFindYorCar');
        $proposta->aplicativoParkEyes        = $request->input('aplicativoParkEyes');
        $proposta->apiAplicativoCliente      = $request->input('apiAplicativoCliente');
        $proposta->apiParaTotens             = $request->input('apiParaTotens');
        $proposta->cliente_id                = $request->input('cliente_id');
       
        $proposta->save();
        $proposta_id = $proposta->id;

       

        foreach($_POST['nomeParque'] as $chave=>$valor){
            $estrutura = new Estrutura();
            $parqueCentralizado             = (isset($_POST['parqueMaisCentralizado'][$chave])) ? 1: 0;
            $estrutura->nomeParque          = $valor;
            $estrutura->qtdVagasInternas    = $_POST['quantidadeVagasInternas'][$chave];
            $estrutura->qtdVagasExternas    = $_POST['quantidadeVagasExternas'][$chave];
            $estrutura->alturaSistema       = $_POST['alturaSistema'][$chave];
            $estrutura->alturaPeDireito     = $_POST['peDireito'][$chave]; 
            $estrutura->parqueCentralizado  = $_POST['parqueMaisCentralizado'][$chave];
            $estrutura->proposta_id         = $proposta_id;
            $estrutura->save();  
        }


        

        for($i = 0; $i <  $_POST['qtdAcessosExternos']; $i++){
            $acesso = new Acesso();
            $acesso->nomeAcesso             = $_POST['nomeAcessoExterno'][$i];
            $acesso->qtdLinhasPaineis       = $_POST['quantidadeLinhasPaineis'][$i];
            $acesso->distanciaProximo       = $_POST['distanciaAcessoProximo'][$i];
            $acesso->proposta_id            = $proposta_id;
            $acesso->save();
        }

        return redirect('/propostas');
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $categorias     = Categoria::all();
        $proposta       = Proposta::find($id);
        
        $estrutura      = Estrutura::where('proposta_id', $id)->get();
        
        // Qtd de vagas.
        $totalDeVagas = 0;
        foreach($estrutura as $key=>$total){
            $totalDeVagas += $total['qtdVagasInternas']+$total['qtdVagasExternas'];
        }

        $valorPorLicenca = $this->retornaValor($totalDeVagas,'Licenças');
        $armazenamentoExtra = $this->valorVariavel(6);
        

        $camerasParkEyesFull = $this->retornaValor($totalDeVagas,'Câmeras+');
        return view('propostas/visualizar', compact('proposta','estrutura','totalDeVagas','valorPorLicenca','armazenamentoExtra','camerasParkEyesFull')); 
    }

    public function valorVariavel($id){
        $variavel       = Variavel::where('id',$id)->get();
        foreach($variavel as $v){
            $valor = $v['valorMinimo'];
        }
        return $valor;
        //return $variavel['valorMinimo'];
    }

    public function retornaValor($totalVagas, $subcategoria_nome){
        $procuraVaga = Vagas::where('minimoDaCategoria','<=',$totalVagas)->where('maximoDaCategoria','>=',$totalVagas)->get();

        foreach($procuraVaga as $k){
            $valor = SubCategoriaVagas::where('vaga_id',$k['id'])->where('subcategoria_nome',$subcategoria_nome)->get();
            foreach($valor as $v){
                $valorRetornar = $v['valor'];
            }
        }

        return $valorRetornar;
        
      
    }
}
