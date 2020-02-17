<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposta;
use App\User;
class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');    
    }

    public function index(){


        $totalDePropostas = Proposta::all()->count();
        $propostas = Proposta::orderBy('created_at', 'desc')->take(8)->get();
        $us = User::orderBy('created_at','desc')->take(5)->get();

        $users = array();
        foreach($us as $key=>$val){
            $proposta = $this->propostasClienteDados($val['id']);
            $total = $proposta->count(); 
            $users[] = array(
                'id' => $val['id'], 
                'name' => $val['name'],
                'total' => $total
            );
        }

        $propostasPorUfs = Proposta::select('uf')
                                        ->selectRaw('count(*) as total')
                                        ->groupBy('uf')
                                        ->get();
        
        
        return view('dashboard', compact('propostas', 'users', 'totalDePropostas', 'propostasPorUfs'));

    }

    public function estados(){
        return view('estados');
    }

    public function estadosPost(){
        $proposta = Proposta::select('uf')->groupBy('uf')->get();

        $ufs = array();
        foreach($proposta as $k=>$v){
            $ufs[] = $v['uf'];
        }

        return response()->json(['success' => true, 'ufs' => $ufs]);
    }

    public function propostasClienteDados($cliente_id){
        $proposta = Proposta::where('cliente_id',$cliente_id)->get();

        return $proposta;
    }

}
