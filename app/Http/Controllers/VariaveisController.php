<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Variavel;

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
                'valorMinimo'       => $var->valorMinimo,
                'valorMedio'        => $var->valorMedio,
                'valorMaximo'       => $var->valorMaximo
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

        $categorias = Categoria::all();

        $cats = array();
        foreach($categorias as $key=>$val){
            $cats[] = array('id' => $val->id, 'nome' => $val->nome);
        }
       
        return view('variaveis/cadastro', compact('cats'));
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

        $var->nome = $request->input('nome');
        $var->categoria_id = $request->input('categoria_id');
        $var->valorMinimo = $request->input('valorMinimo');
        $var->valorMedio = $request->input('valorMedio');
        $var->valorMaximo = $request->input('valorMaximo');
     
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
            'nome' => 'required|max:255|unique:variavels',
            'valorMinimo' => 'required',
            'valorMedio' => 'required',
            'valorMaximo' => 'required'
        ];

        $messages = [
            'nome.required' => 'O campo Nome é obrigatório',
            'valorMinimo.required' => 'O campo valor mínimo é obrigatório',
            'valorMedio.required' => 'O campo valor médio é obrigatório',
            'valorMaximo.required' => 'O campo valor máximo é obrigatório',
            'nome.max'      => 'O limite do Nome é de 255 caracteres',
            'nome.unique'   => 'A Nome informado já está registrado na base de dados'
        ];


        $request->validate($rules, $messages);

        $var = Variavel::find($id);

        if (isset($var)) {
            $var->nome = $request->input('nome');
            $var->categoria_id = $request->input('categoria_id');
            $var->valorMinimo = $request->input('valorMinimo');
            $var->valorMedio = $request->input('valorMedio');
            $var->valorMaximo = $request->input('valorMaximo');
         
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
}
