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
    public function index($id = null)
    {
        $categorias         = Categoria::all();

        $variaveis          = Variavel::orderBy('ordem', 'asc')->get();

        if ($id != null) {

            $variaveis          = Variavel::where('tipo_variavel', '=', $id)->orderBy('ordem', 'asc')->get();
     
        }
        return view('variaveis/index', compact('categorias', 'variaveis'));
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
        foreach ($categorias as $key => $val) {
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
        $var->tipo_variavel = $request->input('tipo_variavel');
        $var->unidade       = $request->input('unidade');

        $var->save();

        return redirect('/variaveis/listar')->with('classe', 'alert-success')->with('mensagem', 'Variável cadastrada com sucesso.');
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
            return view('variaveis/editar', compact('variavel', 'cats'));
        } else {
            return redirect('/variaveis')->with('classe', 'alert-danger')->with('mensagem', 'Variável Inexistente.');
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
            $var->tipo_variavel = $request->input('tipo_variavel');
            $var->valor = Helper::moedaDolar($request->input('valor'));
            $var->unidade = $request->input('unidade');

            $var->save();
        } else {
            return redirect('/variaveis/listar')->with('classe', 'alert-danger')->with('mensagem', 'Erro ao atualizar variável. Tente novamente.');
        }
        return redirect('/variaveis/listar')->with('classe', 'alert-info')->with('mensagem', 'Variável atualizada com sucesso.');
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
            return redirect('/variaveis')->with('classe', 'alert-danger')->with('mensagem', 'Variável Inexistente.');
        }
        return redirect('/variaveis')->with('classe', 'alert-danger')->with('mensagem', 'Variável removida com sucesso.');;
    }


    public function salvaOrdem()
    {
        return view('salvaOrdem');
    }

    /*ajax*/
    public function salvaOrdemPost(Request $request)
    {
        $input = $request->all();

        $var = Variavel::find($input['variavel']);
        if (isset($var)) {
            $var->ordem = $input['ordem'];
            $var->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function retornaVariaveisCliente($cliente_id, $categoria_id, $tipo)
    {
      
            if($tipo=='full'){
                $vars = array(0,2);
            }else{
                $vars = array(1,2);
            }
            $variaveisDoCliente = User::where('users.id', '=', $cliente_id)
                ->where('categorias.id', '=', $categoria_id)
                ->whereIn('variavels.tipo_variavel', $vars)
                ->join('sub_precos_fixos', 'sub_precos_fixos.sub_fixo_id', '=', 'users.sub_fixo_id')
                ->join('variavels', 'variavels.id', '=', 'sub_precos_fixos.categoria_fixo_id')
                ->join('categorias', 'categorias.id', '=', 'variavels.categoria_id')
                ->leftjoin('regra_pergunta_variavels', 'regra_pergunta_variavels.variavel_id', '=', 'variavels.id')
                ->select(
                    'categorias.id as categoria_id',
                    'regra_pergunta_variavels.regra_de_negocio',
                    'variavels.nome',
                    'variavels.id as variavel_id',
                    'sub_precos_fixos.preco',
                    'sub_precos_fixos.sub_fixo_id',
                    'variavels.unidade'
                )
                ->orderBy('variavels.ordem', 'asc')
                ->get();
                 
        return $variaveisDoCliente;
    }
}
