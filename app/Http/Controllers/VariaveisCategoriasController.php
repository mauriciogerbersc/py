<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;


class VariaveisCategoriasController extends Controller
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
        $categorias = Categoria::orderBy('created_at','asc')->get();

        return view('variaveis/indexCategoria', compact('categorias'));
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
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id);

        if (isset($categoria)) {
            return view('variaveis/editarCategoria', compact('categoria'));
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
}
