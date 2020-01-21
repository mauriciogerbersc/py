<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provisao;

class ProvisaoController extends Controller
{
    public function __construct()
    {


        $this->middleware('auth:admin');
    }


    public function index()
    {

        $produtox =  Provisao::all();

        $produtos = array();
        foreach ($produtox as $prod) {
            $categoria = 'Basic';
            if ($prod['categoriaProduto'] == 1) {
                $categoria = 'Full';
            }

            $produtos[] = array(
                'id' => $prod['id'],
                'categoriaProduto' => $categoria,
                'ncm' => $prod['ncm'],
                'produto' => $prod['produto'],
                'preco' => $prod['preco'],
                'descricao' => $prod['descricao']
            );
        }


        return view('provisao/indexProduto', compact('produtos'));
    }


    public function create()
    {
        return view('provisao/novoProduto');
    }


    public function edit($id){

        $provisao      = Provisao::find($id);
      
        if (isset($provisao)) {
            return view('provisao/editarProduto', compact('provisao'));
        } else {
            return redirect('provisao/produtos');
        }

        
    }

    public function store(Request $request)
    {

        $rules = [
            'ncm' => 'required|max:255',
            'produto' => 'required|max:255',
            'preco' => 'required',
            'partnumber' => 'required'
        ];

        $messages = [
            'ncm.required' => 'O campo NCM é obrigatório',
            'produto.required' => 'O campo Produto é obrigatório',
            'preco.required' => 'O campo Preço é obrigatório',
            'partnumber.required'     => 'O campo Part Number é obrigatório'
        ];

        $request->validate($rules, $messages);


        $provisao = new Provisao();


        $provisao->categoriaProduto = $request->input('categoria_produto');
        $provisao->ncm = $request->input('ncm');
        $provisao->produto = $request->input('produto');
        $provisao->preco = $request->input('preco');
        $provisao->aliquota_imposto_importacao = $request->input('importacao');
        $provisao->part_number = $request->input('partnumber');
        $provisao->aliquotaIPI = $request->input('ipi');
        $provisao->aliquotaPIS = $request->input('pis');
        $provisao->aliquotaICMS = $request->input('icms');
        $provisao->aliquotaConfis = $request->input('cofins');
        $provisao->descricao    = $request->input('descricao');

        $provisao->save();


        return redirect('/provisao/produtos');
    }


    public function update(Request $request, $id){

        
        $rules = [
            'ncm' => 'required|max:255',
            'produto' => 'required|max:255',
            'preco' => 'required',
            'partnumber' => 'required'
        ];

        $messages = [
            'ncm.required' => 'O campo NCM é obrigatório',
            'produto.required' => 'O campo Produto é obrigatório',
            'preco.required' => 'O campo Preço é obrigatório',
            'partnumber.required'     => 'O campo Part Number é obrigatório'
        ];

        $request->validate($rules, $messages);

        $provisao = Provisao::find($id);


        if (isset($provisao)) {
            
            $provisao->categoriaProduto = $request->input('categoria_produto');
            $provisao->ncm = $request->input('ncm');
            $provisao->produto = $request->input('produto');
            $provisao->preco = $request->input('preco');
            $provisao->aliquota_imposto_importacao = $request->input('importacao');
            $provisao->part_number = $request->input('partnumber');
            $provisao->aliquotaIPI = $request->input('ipi');
            $provisao->aliquotaPIS = $request->input('pis');
            $provisao->aliquotaICMS = $request->input('icms');
            $provisao->aliquotaConfis = $request->input('cofins');
            $provisao->descricao    = $request->input('descricao');
            
            $provisao->save();
        } else {
            return redirect('provisao/produtos');
        }
        return redirect('provisao/produtos');

    }

}
