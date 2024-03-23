<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Grupo;

class ClienteController extends Controller
{
    /**
     * Listar clientes cadastrados
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Clientes()
    {
        try{
            return response()->json(Cliente::all());
        }catch(Exception $e){
            return response()->json($e);
        }
    }
    
    /**
     * Listar detalhes de um cliente
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Cliente($id)
    {
        try{
            $cliente = Cliente::find($id);
            if(!is_null($cliente)){
                $cliente->grupo;
                return response()->json($cliente);
            }else{
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Cadastrar cliente
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Criar(Request $request)
    {
        try{
            // valida dados
            $erros = $this->Validar($request);
            if(count($erros) > 0){
                return response()->json(['erros' => $erros], 503);
            }

            // cria o cliente
            $cliente = Cliente::create([
                'grupo_id' => $request->grupo_id,
                'nome' => $request->nome,
                'cnpj' => $request->cnpj,
                'data_fundacao' => $request->data_fundacao
            ]);

            if(!is_null($cliente)){
                return response()->json($cliente);
            }else{
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Editar cliente
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Editar(Request $request)
    {
        try{
            $cliente = Cliente::find($request->id);
            if(!is_null($cliente)){
                // valida dados
                $erros = $this->Validar($request);
                if(count($erros) > 0){
                    return response()->json(['erros' => $erros], 503);
                }

                // edita o cliente
                $cliente->grupo_id = $request->grupo_id;
                $cliente->nome = $request->nome;
                $cliente->cnpj = $request->cnpj;
                $cliente->data_fundacao = $request->data_fundacao;

                // salva o cliente
                if($cliente->save()){
                    return response()->json($cliente);
                }else{
                    return response()->json(['erro' => 'Erro ao salvar o cliente'], 501);        
                }
            }else{
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Deletar cliente
     * Apenas gerentes de nível 2
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function Deletar(Request $request)
    {
        try{
            $cliente = Cliente::find($request->id);
            if(!is_null($cliente)){
                if($cliente->delete($request->id)){
                    return response()->json(['successo' => 'Cliente removido com sucesso']);
                }else{
                    return response()->json(['erro' => 'Erro ao remover o cliente'], 501);
                }
            }else{
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
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
        // valida o grupo
        $grupo = Grupo::find($request->grupo_id);
        if(is_null($grupo)){
            $erros[] = 'O Grupo é obrigatório';
        }

        // valida o nome
        if($request->nome == ''){
            $erros[] = 'O Nome é obrigatório';
        }

        // valida CNPJ
        if(!$this->ValidarCnpj($request->cnpj)){
            $erros[] = 'O CNPJ deve ser informado corretamente';
        }

        // valida data
        $data = explode('-',$request->data_fundacao);
        if(count($data) != 3 || !checkdate($data[1], $data[2], $data[0])){
            $erros[] = 'A Data de Funação está inválida';
        }
        
        return $erros;
    }

    /**
     * Valida CNPJ
     * 
     * @return bool
     */
    protected function ValidarCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
    
        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;	
    
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
    
        $resto = $soma % 11;
    
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;
    
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
    
        $resto = $soma % 11;
    
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
