<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vagas;
use App\SubCategoriaVagas;
use App\Estrutura;

use Helper;


class VagasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function create()
    {

        $vagas = Vagas::all();

        $vagasArray = array();
        foreach ($vagas as $key => $val) {
            $vagasArray[] = array('id' => $val->id, 'nome' => $val->nome);
        }

        return view('vagas/cadastroSubCategoria', compact('vagasArray'));
    }


    public function totalDeVagas($proposta_id){
        $estrutura          = Estrutura::where('proposta_id', $proposta_id)->get();
        $totalDeVagas       = 0;
        $vagasDescobertas   = 0;
        $vagasInternas      = 0;
        foreach ($estrutura as $key => $total) {
            $totalDeVagas       += $total['qtdVagasInternas'] + $total['qtdVagasExternas'];
            $vagasDescobertas   += $total['qtdVagasExternas'];
            $vagasInternas      += $total['qtdVagasInternas'];
        }


        $arr = array('totalDeVagas' => $totalDeVagas, 'totalDeVagasInternas' => $vagasInternas);
        return $arr;
    }

    public function indexSubCategorias()
    {

        $subs = SubCategoriaVagas::orderBy('subcategoria_nome', 'asc')->get();;

        $subCategorias = array();
        foreach ($subs as $var) {
            $subCategorias[] = array(
                'id'                => $var->id,
                'subcategoria_nome' => $var->subcategoria_nome,
                'vagas_nome'        => $var->vaga->nome,
                'valor'             => "R$ " . Helper::moedaReal($var->valor)
            );
        }


        return view('vagas/subcategorias', compact('subCategorias'));
    }

    public function storeSub(Request $request)
    {   

 
        $rules = [
            'subcategoria_nome' => 'required|max:255'
        ];

        $messages = [
            'subcategoria_nome.required' => 'O campo Subcategoria é obrigatório',
            'subcategoria_nome.max'      => 'O limite do Subcategoria é de 255 caracteres'
        ];

        $request->validate($rules, $messages);


        $subcategoria = new SubCategoriaVagas();
        $subcategoria->subcategoria_nome    = $request->input('subcategoria_nome');
        $subcategoria->vaga_id              = $request->input('vaga_id');
        $subcategoria->valor                = Helper::moedaDolar($request->input('valor'));

        $subcategoria->save();

        return redirect('/vagas/subcategorias');
    }


    public function editarSubCategoria($id)
    {
        $subCategoria       = SubCategoriaVagas::find($id);

        $vagasArray         = Vagas::all();
        if (isset($subCategoria)) {
            return view('/vagas/editarSubCategoria', compact('vagasArray', 'subCategoria'));
        } else {
            return view('/vagas/subcagetegorias');
        }
    }


    public function updateSubCategoria(Request $request, $id)
    {
//http://127.0.0.1:8000/vagas/subcategorias/editar/17
        $rules = [
            'subcategoria_nome' => 'required|max:255'
        ];

        $messages = [
            'subcategoria_nome.required' => 'O campo Subcategoria é obrigatório',
            'subcategoria_nome.max'      => 'O limite do Subcategoria é de 255 caracteres'
        ];

        $request->validate($rules, $messages);


        $subcategoria = SubCategoriaVagas::find($id);

        if (isset($subcategoria)) {
            $subcategoria->subcategoria_nome    = $request->input('subcategoria_nome');
            $subcategoria->vaga_id              = $request->input('vaga_id');
            $subcategoria->valor                = Helper::moedaDolar($request->input('valor'));
         
            $subcategoria->save();
        } else {
            return view('/vagas/subcategorias');
        }
        return redirect('/vagas/subcategorias');
    }

    public function removerSubCategoria($id)
    {
        $sub = SubCategoriaVagas::find($id);
        if (isset($sub)) {
            $sub->delete();
        } else {
            return view('/vagas/subcategorias');
        }
        return redirect('/vagas/subcategorias');
    }
}
