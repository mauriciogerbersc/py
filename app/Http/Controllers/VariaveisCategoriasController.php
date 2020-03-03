<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\CategoriasPrecosFixos;
use App\Variavel;
use App\SubFixos;
use App\SubPrecosFixos;
use App\SubCategoriaVagas;
use App\Vagas;
use Helper;

class VariaveisCategoriasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function subcategoriaIndex()
    {

        $titulo  = "Tabelas de Preços";
        $ids = array(53,54);
        $arr = SubFixos::where('status', '=', 1)
                        ->whereNotIn('id',$ids)
                        ->orderBy('id', 'asc')
                        ->get();
            $tabelas = '';             
       // $tabelas = SubFixos::whereNotIn('id',$ids)->where('status', '=', 1)->orderBy('id', 'desc')->groupBy('tabela_pai')->get();
        return view('variaveis/indexSubCategoria', compact('arr','tabelas', 'titulo'));
    }


    public function retornaPai($id){
        $subFixo = SubFixos::where('id','=',$id)->select('nomeSub')->first();

        return $subFixo['nomeSub'];

    }

    public function subcategoriaNova($tipo)
    {

        $categorias = Categoria::all();
        $vagas = Vagas::all();

        $subsCategorias = SubCategoriaVagas::orderBy('subcategoria_nome', 'asc')->get();
        $subs = array();
        foreach($subsCategorias as $key=>$val)
        {
            $subs[] = array('id'                    => $val['id'],
                            'subcategoria_nome'     => $val['subcategoria_nome'],
                            'valor'                 => number_format($val['valor'], 2,'.',''),
                            'vaga_id'               => $val['vaga_id']);
        }
       
        $vars = Variavel::where('categoria_id', '!=', 11)
                        ->orderBy('created_at', 'asc')->get();
        
        if($tipo == 'full'){
            $vars = Variavel::where('tipo_variavel', '!=', 1)
                            ->orderBy('ordem', 'asc')
                            ->get();
        }elseif($tipo == 'basic'){
            $vars = Variavel::where('tipo_variavel', '!=', 0)
                              ->where('tipo_variavel', '=', 2)
                              ->orWhere('tipo_variavel', '=', 1)
                              ->orderBy('ordem', 'asc')
                              ->get();
        }

        $variaveis = array();
        foreach ($vars as $k => $valores) 
        {
            $variaveis[] = array('valorFormatado'       => number_format($valores['valor'], 2,'.',''),
                                'valor'                 => $valores['valor'],
                                'id'                    => $valores['id'], 
                                'nome'                  => $valores['nome'], 
                                'categoria_id'          => $valores['categoria_id']);
        }

        return view('variaveis/cadastroSubCategoria', compact('variaveis', 'subs', 'vagas', 'categorias'));
    }


    public function visualizar($id){
       
        $vagas              = Vagas::all();

        $categorias         = Categoria::all();
        $subPrecosCad       = SubPrecosFixos::where('sub_fixo_id', $id)->get();
        ## Variáveis já cadastradas das que estou editando
        $categoriasPrecosFixos     = CategoriasPrecosFixos::where('sub_fixos_id', $id)->get();

        $subPrecos = array();
        foreach($subPrecosCad as $k=>$v)
        {
            $subPrecos[] = array('id' => $v['id'],
                                'categoria_fixo_id' => $v['categoria_fixo_id'],
                                'preco' => $v['preco'],
                                'precoFormatado' => number_format($v['preco'], 2,'.',''),
                                'sub_fixo_id' => $v['sub_fixo_id']);
        }
     
        $subFixos           = SubFixos::where('id', $id)->first();
        
        #$vars = Variavel::orderBy('created_at', 'asc')->get();
        $vars = Variavel::join('sub_precos_fixos', 'sub_precos_fixos.categoria_fixo_id', '=', 'variavels.id')
                        ->where('sub_precos_fixos.sub_fixo_id', '=', $id)
                        ->select('sub_precos_fixos.preco', 'variavels.id', 'variavels.categoria_id', 'variavels.nome')
                        ->get();

        
        $variaveis = array();
        foreach ($vars as $k => $valores) 
        {
            $variaveis[] = array('valorFormatado'       => number_format($valores['preco'], 2,'.',''),
                                'valor'                 => $valores['preco'],
                                'id'                    => $valores['id'], 
                                'nome'                  => $valores['nome'], 
                                'categoria_id'          => $valores['categoria_id']);
        }
        
        $subsCategorias = SubCategoriaVagas::orderBy('subcategoria_nome', 'asc')->get();
        $subs = array();
        foreach($subsCategorias as $key=>$val)
        {
            $subs[] = array('id'                    => $val['id'],
                            'subcategoria_nome'     => $val['subcategoria_nome'],
                            'valor'                 => number_format($val['valor'], 2),
                            'vaga_id'               => $val['vaga_id']);
        }

      
        if (isset($subPrecos)) {
            return view('/variaveis/visualizarTabela', 
            compact('vagas', 'subPrecos', 'variaveis', 'subs', 'categorias', 'subFixos', 'categoriasPrecosFixos')
        );
        } else {
            return view('/variaveis/subcategorias');
        }

    }
    public function editCategoriaNova($id)
    {
        $titulo             = "Nova Tabela a partir";
        $vagas              = Vagas::all();

        $categorias         = Categoria::all();
        $subPrecosCad       = SubPrecosFixos::where('sub_fixo_id', $id)->get();
        ## Variáveis já cadastradas das que estou editando
        $precosFixos     = CategoriasPrecosFixos::where('sub_fixos_id', $id)->get();
        $categoriasPrecosFixos      = array();

        foreach($precosFixos as $key=>$val){
            $categoriasPrecosFixos[] = array('sub_categoria_id' => $val['sub_categoria_id'],
            'vaga_id' => $val['vaga_id'],
            'preco' => number_format($val['preco'], 2,'.',''),);
        }
       
        $subPrecos = array();
        foreach($subPrecosCad as $k=>$v)
        {
            $subPrecos[] = array('id' => $v['id'],
                                'categoria_fixo_id' => $v['categoria_fixo_id'],
                                'preco' => $v['preco'],
                                'precoFormatado' => number_format($v['preco'], 2,'.',''),
                                'sub_fixo_id' => $v['sub_fixo_id']);
        }
     
        $subFixos           = SubFixos::where('id', $id)->first();
        
        #$vars = Variavel::orderBy('created_at', 'asc')->get();
        $vars = Variavel::join('sub_precos_fixos', 'sub_precos_fixos.categoria_fixo_id', '=', 'variavels.id')
                        ->where('sub_precos_fixos.sub_fixo_id', '=', $id)
                        ->select('sub_precos_fixos.preco', 'variavels.id', 'variavels.categoria_id', 'variavels.nome')
                        ->get();

        $variaveis = array();
        foreach ($vars as $k => $valores) 
        {
            $variaveis[] = array('valorFormatado'       => number_format($valores['preco'], 2), 
                                'valor'                 => $valores['preco'],
                                'id'                    => $valores['id'], 
                                'nome'                  => $valores['nome'], 
                                'categoria_id'          => $valores['categoria_id']);
        }
        
        $subsCategorias = SubCategoriaVagas::orderBy('subcategoria_nome', 'asc')->get();
        $subs = array();
        foreach($subsCategorias as $key=>$val)
        {
            $subs[] = array('id'                    => $val['id'],
                            'subcategoria_nome'     => $val['subcategoria_nome'],
                            'valor'                 => number_format($val['valor'], 2),
                            'vaga_id'               => $val['vaga_id']);
        }

      
        if (isset($subPrecos)) {
            return view('/variaveis/editarSubCategoria', 
            compact('vagas', 'subPrecos', 'variaveis', 'subs', 'categorias', 'subFixos', 'categoriasPrecosFixos', 'titulo')
        );
        } else {
            return view('/variaveis/subcategorias');
        }
    }


    /*
        Nesse caso eu devo criar uma nova categoria, herdando os dados da categoria pai.

    */

    public function saveCategoriaNova(Request $request, $id)
    {

        $rules = [
            'nomeSubGrupo' => 'required',
            'descontoDado' => 'required'
        ];

        $messages = [
            'nomeSubGrupo.required' => 'O campo nome do sub grupo é obrigatório',
            'descontoDado.required' => 'O campo desconto é obrigatório'
        ];

        $request->validate($rules, $messages);

        /*
        1. Criar nova categoria na tabela `sub_fixos` e armazeno o ID da tabela pai. 
        (no caso a tabela que estou herdando os dados)
        */
        if(($id == 54) OR ($id == 53)){
            $id = 0;
        }
        $subFixo = new SubFixos();

        $subFixo->nomeSub      = $request->input('nomeSubGrupo');
        $subFixo->descontoDado = $request->input('descontoDado');
        $subFixo->tabela_pai   = $id;
        $subFixo->status       = 1;
        $subFixo->save();

        /*
        2. Recupero o id da tabela de proposta criado na`sub_fixos`
        */
        $subId = $subFixo->id;

        if ($subId) {
            foreach ($_POST['valor'] as $key => $val) {
                $subPrecosFixos = new SubPrecosFixos();
                $subPrecosFixos->categoria_fixo_id  = $key;
                $subPrecosFixos->preco              = Helper::brl2decimal($val);
                $subPrecosFixos->sub_fixo_id        = $subId;
                $subPrecosFixos->tabela_pai         = $id;
                $subPrecosFixos->save();
            }

            foreach ($_POST['intervalo_vagas'] as $chave => $valor) {

                foreach ($_POST['valor_fixo'] as $key => $val) {
                    if ($chave == $key) {
                        foreach ($val as $k => $v) {
                            $categoriaPrecosFixos = new CategoriasPrecosFixos();
                            $categoriaPrecosFixos->vaga_id          = $valor;
                            $categoriaPrecosFixos->sub_categoria_id = $k;
                            $categoriaPrecosFixos->preco            = Helper::brl2decimal($v);
                            $categoriaPrecosFixos->sub_fixos_id     = $subId;
                            $categoriaPrecosFixos->save();
                        }
                    }
                }
            }
        }
        
       /* $subPrecos          = SubPrecosFixos::where('sub_fixo_id', $id)->get();

        // as variaveis específicas dessa categoria já cadastradas no banco
        $idsQueJaTenho = array();
        foreach ($subPrecos as $subs) {
            $idsQueJaTenho[$subs['categoria_fixo_id']] = $subs['categoria_fixo_id'];
        }

        // Verifico todos os Ids de variáveis que recebi novos.
        $idsQueRecebi = array();
        foreach ($_POST['valor'] as $key => $val) {
            $idsQueRecebi[$key] = array('valor' => $val);
        }

        // Verifico se existe diferença entre os dois arrays, se existir, devo inserir novo array.
        $diferencas = array_diff_key($idsQueRecebi, $idsQueJaTenho);
        if (!empty($diferencas)) {
            foreach ($diferencas as $k => $v) {
                $subPrecosFixos = new SubPrecosFixos();
                $subPrecosFixos->categoria_fixo_id  = $k;
                $subPrecosFixos->preco              = $v['valor'];
                $subPrecosFixos->sub_fixo_id        = $id;
                $subPrecosFixos->save();
            }
        }
        */

        return redirect('/variaveis/subcategorias')->with('classe', 'alert-success')->with('mensagem', 'Tabela de Preços criada com sucesso.');
    }

 
    public function storeSubCategoriaNova(Request $request)
    {
        $rules = [
            'nomeSubGrupo' => 'required',
            'descontoDado' => 'required'
        ];

        $messages = [
            'nomeSubGrupo.required' => 'O campo nome do sub grupo é obrigatório',
            'descontoDado.required' => 'O campo desconto é obrigatório'
        ];

        $request->validate($rules, $messages);


        $subFixo = new SubFixos();

        $subFixo->nomeSub = $request->input('nomeSubGrupo');
        $subFixo->descontoDado = $request->input('descontoDado');
        $subFixo->save();

        $subId = $subFixo->id;

        if ($subId) {
            foreach ($_POST['valor'] as $key => $val) {
                $subPrecosFixos = new SubPrecosFixos();
                $subPrecosFixos->categoria_fixo_id  = $key;
                $subPrecosFixos->preco              = Helper::brl2decimal($val);
                $subPrecosFixos->sub_fixo_id        = $subId;
                $subPrecosFixos->save();
            }

            foreach ($_POST['intervalo_vagas'] as $chave => $valor) {

                foreach ($_POST['valor_fixo'] as $key => $val) {
                    if ($chave == $key) {
                        foreach ($val as $k => $v) {
                            $categoriaPrecosFixos = new CategoriasPrecosFixos();
                            $categoriaPrecosFixos->vaga_id          = $valor;
                            $categoriaPrecosFixos->sub_categoria_id = $k;
                            $categoriaPrecosFixos->preco            = Helper::brl2decimal($v);
                            $categoriaPrecosFixos->sub_fixos_id     = $subId;
                            $categoriaPrecosFixos->save();
                        }
                    }
                }
            }
        }




        return redirect('/variaveis/subcategorias')->with('classe', 'alert-success')->with('mensagem', 'Tabela criada com sucesso.');;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $titulo     = "Categorias";
        $categorias = Categoria::orderBy('created_at', 'asc')->get();

        return view('variaveis/indexCategoria', compact('categorias','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('variaveis/cadastroCategoria');
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
            'nome' => 'required|max:255|unique:categorias'
        ];

        $messages = [
            'nome.required' => 'O campo Categoria é obrigatório',
            'nome.max'      => 'O limite do Categoria é de 255 caracteres',
            'nome.unique'   => 'A categoria informa já está registrado na base de dados'
        ];

        $request->validate($rules, $messages);


        $categoria = new Categoria();

        $categoria->nome = $request->input('nome');

        $categoria->save();

        return redirect('/variaveis/categorias/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titulo    = "Editar Categoria";
        $categoria = Categoria::find($id);

        if (isset($categoria)) {
            return view('variaveis/editarCategoria', compact('categoria','titulo'));
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
            'nome' => 'required|max:255|unique:categorias'
        ];

        $messages = [
            'nome.required' => 'O campo Categoria é obrigatório',
            'nome.max'      => 'O limite do Categoria é de 255 caracteres',
            'nome.unique'   => 'A categoria informa já está registrado na base de dados'
        ];


        $request->validate($rules, $messages);

        $categoria = Categoria::find($id);

        if (isset($categoria)) {
            $categoria->nome = $request->input('nome');
            $categoria->save();
        } else {
            return view('/variaveis/categorias');
        }
        return redirect('/variaveis/categorias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if (isset($categoria)) {
            $categoria->delete();
        } else {
            return view('/variaveis/categorias');
        }
        return redirect('/variaveis/categorias');
    }

    public function removeCategoriaNova($id)
    {

        $subPrecosFixos     = SubPrecosFixos::where('sub_fixo_id', '=', $id);
        $subFixos           = SubFixos::find($id);
        $categoriasPrecos   = CategoriasPrecosFixos::where('sub_fixos_id', '=', $id);

        if (isset($subPrecosFixos)) {
            $subPrecosFixos->delete();
            $subFixos->delete();
            $categoriasPrecos->delete();

            return redirect('/variaveis/subcategorias')->with('classe', 'alert-info')->with('mensagem', 'Tabela removida com sucesso.');
        } else {
            return view('/variaveis/subcategorias');
        }
    }
}
