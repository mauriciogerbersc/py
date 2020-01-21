<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Proposta;
use App\SubFixos;

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
        
        $users = User::leftJoin('sub_fixos', 'sub_fixos.id', '=', 'users.sub_fixo_id')
                        ->select('users.id', 'users.name', 'sub_fixos.nomeSub')    
                        ->get();

        return view('clientes/index', compact('users'));
    }


    public function propostasClienteDados($cliente_id){
        $proposta = Proposta::where('cliente_id',$cliente_id)->get();

        return $proposta;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $subFixo       = SubFixos::All();
        return view('clientes/cadastro', compact("subFixo"));
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
        $user->sub_fixo_id = $request->input('categoriaPrecos');
        $user->save();

        return redirect('/clientes')->with('classe', 'alert-success')->with('mensagem', 'Cliente criado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subFixo       = SubFixos::All();
        $cliente       = User::find($id);

        if (isset($cliente)) {
            return view('/clientes/editar', compact('subFixo', 'cliente'));
        } else {
            return view('/clientes');
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
            'email' => 'required',
            'name'  => 'required|max:255',
        ];

        $messages = [
            'name.required'         => 'O campo Nome é obrigatório',
            'name.max'              => 'O limite do Nome é de 255 caracteres',
            'email.required'        => 'O campo Email é obrigatório'
        ];
        
        $request->validate($rules, $messages);

        $user = User::find($id);

        
        $user->name         = $request->input('name');
        $user->email        = $request->input('email');
        $user->sub_fixo_id  = $request->input('categoriaPrecos');
        if($request->input('password')!=''){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect('/clientes')->with('classe', 'alert-info')->with('mensagem', 'Dados do Cliente atualizados com sucesso.');

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
