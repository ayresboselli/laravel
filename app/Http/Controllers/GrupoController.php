<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grupo;

class GrupoController extends Controller
{
    /**
     * Listar grupos cadastrados
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Grupos()
    {
        try{
            return response()->json(Grupo::all());
        }catch(Exception $e){
            return response()->json($e);
        }
    }
    
    /**
     * Listar detalhes de um grupo
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Grupo($id)
    {
        $grupo = Grupo::find($id);
        $grupo->clientes;
        return response()->json($grupo);
    }

    /**
     * Cadastrar grupo
     * Apenas gerentes de nível 2
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Criar(Request $request)
    {
        try{
            $erros = $this->Validar($request);
            if(count($erros) > 0){
                return response()->json(['erros' => $erros], 503);
            }

            // cria o grupo
            $grupo = Grupo::create([ 'nome' => $request->nome]);
            if(!is_null($grupo)){
                return response()->json($grupo);
            }else{
                return response()->json(['erro' => 'Grupo não encontrado'], 404);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Editar grupo
     * Apenas gerentes de nível 2
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Editar(Request $request)
    {
        try{
            $grupo = Grupo::find($request->id);

            if(!is_null($grupo)){
                // valida dados
                $erros = $this->Validar($request);
                if(count($erros) > 0){
                    return response()->json(['erros' => $erros], 503);
                }

                // edita o grupo
                $grupo->nome = $request->nome;

                // salva o grupo
                if($grupo->save()){
                    return response()->json($grupo);
                }else{
                    return response()->json(['erro' => 'Erro ao salvar o grupo'], 501);
                }
            }else{
                return response()->json(['erro' => 'Grupo não encontrado'], 404);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Deletar grupo
     * Apenas gerentes de nível 2
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Deletar(Request $request)
    {
        try{
            $grupo = Grupo::find($request->id);
            if(!is_null($grupo)){
                if($grupo->delete()){
                    return response()->json(['successo' => 'Grupo removido com sucesso']);
                }else{
                    return response()->json(['erro' => 'Erro ao remover o grupo'], 501);        
                }
            }else{
                return response()->json(['erro' => 'Grupo não encontrado'], 404);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    
    /**
     * Valida dados da requisição
     * 
     * @return array
     */
    protected function Validar($request)
    {
        $erros = [];

        // valida o nome
        if($request->nome == ''){
            $erros[] = 'O Nome é obrigatório';
        }

        return $erros;
    }
}
