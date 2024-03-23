<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Gera o token JWT.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Login()
    {
        $credenciais = request(['email', 'password']);

        if (! $token = auth()->attempt($credenciais)) {
            return response()->json(['erro' => 'Acesso não autorizado'], 401);
        }

        return response()->json([
            'token' => $token,
            'tipo' => 'Bearer',
            'expira_em' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Retorna dados do gerente logado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Gerente()
    {
        // if(!is_null(auth()->user())){
            return response()->json([
                'id' => auth()->user()->id,
                'nome' => auth()->user()->name,
                'email' => auth()->user()->email,
                'nível' => auth()->user()->level,
                'criado_em' => auth()->user()->created_at,
                'atualizado_em' => auth()->user()->updated_at,
            ]);
        // }else{
        //     return response()->json(['erro' => 'Acesso não autorizado'], 401);
        // }
    }

    /**
     * Invalida o token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Logout()
    {
        if(!is_null(auth()->user())){
            auth()->logout();

            return response()->json(['message' => 'Logout realizado com sucesso']);
        }else{
            return response()->json(['erro' => 'Acesso não autorizado'], 401);
        }
    }
}
