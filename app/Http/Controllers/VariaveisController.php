<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Variavel;
use App\Vagas;
use App\User;

use Helper;
class VariaveisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $variaveis = Variavel::all();

        $arr = array();
        foreach($variaveis as $var){
            $arr[] = array(
                'id'                => $var->id,
                'nome'              => $var->nome,
                'categoria_nome'    => $var->categoria->nome,
                'valor'             => "R$ " . Helper::moedaReal($var->valor),
            );
        }
        
      
        return view('variaveis/index', compact('arr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $vagas      = Vagas::all();
        $categorias = Categoria::all();

        $cats = array();
        foreach($categorias as $key=>$val){
            $cats[] = array('id' => $val->id, 'nome' => $val->nome);
        }
       
        return view('variaveis/cadastro', compact('cats', 'vagas'));
    }


   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'nome' => 'required|max:255|unique:variavels'
        ];

        $messages = [
            'nome.required' => 'O campo Nome é obrigatório',
            'nome.max'      => 'O limite do Nome é de 255 caracteres',
            'nome.unique'   => 'A Nome informado já está registrado na base de dados'
        ];
        
        $request->validate($rules, $messages);


        $var = new Variavel();

        $var->nome          = $request->input('nome');
        $var->categoria_id  = $request->input('categoria_id');
        $var->valor         = Helper::moedaDolar($request->input('valor'));
     
        $var->save();

        return redirect('/variaveis');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $variavel       = Variavel::find($id);
        $cats           = Categoria::all();
        if (isset($variavel)) {
            return view('variaveis/editar', compact('variavel','cats'));
        } else {
            return view('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       
        $rules = [
            'nome' => 'required|max:255',
            'valor' => 'required'
        ];

        $messages = [
            'nome.required' => 'O campo Nome é obrigatório',
            'valor.required' => 'O campo valor mínimo é obrigatório',
            'nome.max'      => 'O limite do Nome é de 255 caracteres'
        ];


        $request->validate($rules, $messages);

        $var = Variavel::find($id);

        if (isset($var)) {
            $var->nome = $request->input('nome');
            $var->categoria_id = $request->input('categoria_id');
            $var->valor = Helper::moedaDolar($request->input('valor'));
         
            $var->save();
        } else {
            return view('/variaveis');
        }
        return redirect('/variaveis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $var = Variavel::find($id);
        if (isset($var)) {
            $var->delete();
        } else {
            return view('/variaveis');
        }
        return redirect('/variaveis');
    }



    public function retornaVariaveisCliente($cliente_id, $categoria_id){
        $variaveisDoCliente = User::where('users.id', '=', $cliente_id)
                                    ->where('categorias.id', '=', $categoria_id)
                                    ->join('sub_precos_fixos', 'sub_precos_fixos.sub_fixo_id', '=', 'users.sub_fixo_id')
                                    ->join('variavels', 'variavels.id', '=', 'sub_precos_fixos.categoria_fixo_id')
                                    ->join('categorias', 'categorias.id', '=', 'variavels.categoria_id')
                                    ->leftjoin('regra_pergunta_variavels', 'regra_pergunta_variavels.variavel_id', '=', 'variavels.id')
                                    ->select(   'categorias.id as categoria_id',
                                                'regra_pergunta_variavels.regra_de_negocio', 
                                                'variavels.nome',
                                                'variavels.id as variavel_id',
                                                'sub_precos_fixos.preco', 
                                                'sub_precos_fixos.sub_fixo_id'
                                            )
                                    ->orderBy('variavels.nome', 'asc')
                                    ->get();

        
        return $variaveisDoCliente;
    }
}
