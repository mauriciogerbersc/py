<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
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

        $users = User::all();

        return view('clientes/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes/cadastro');
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
            'email' => 'required|unique:users',
            'name'  => 'required|max:255',
            'password' => 'required|string|min:4|confirmed',
        ];

        $messages = [
            'name.required' => 'O campo Nome é obrigatório',
            'name.max'      => 'O limite do Nome é de 255 caracteres',
            'email.required' => 'O campo Email é obrigatório',
            'email.unique'   => 'O email já está registrado na base de dadoss',
            'password.required'     => 'O campo senha é obrigatório',
            'password.confirmed'        => 'Confirme sua senha',
            'password.min'      => 'O mínimo para o campo senha é de 4 caracteres'
        ];
        
        $request->validate($rules, $messages);

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect('/clientes');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
