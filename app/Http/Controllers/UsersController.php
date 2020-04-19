<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function create(Request $request)
    {
        $dados['name']     = $request['name'];
        $dados['email']    = $request['email'];
        $dados['password'] = bcrypt($request['password']);

        try {

            User::create($dados);
            return response()->json([], 204);

        } catch(\Exception $e) {
            return response()->json(['data' => 'Ocorreu um erro'], 400);
        }
        
    }


}

