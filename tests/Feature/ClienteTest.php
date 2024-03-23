<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;

class ClienteTest extends TestCase
{
    /**
     * Listar clientes
     *
     * @return void
     */
    public function test_clientes()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/clientes');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "id",
                    "grupo_id",
                    "nome",
                    "cnpj",
                    "data_fundacao",
                    "created_at",
                    "updated_at"
                ]
            ]);
    }
    
    /**
     * detalhes de um cliente
     *
     * @return void
     */
    public function test_cliente_detalhes()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $cliente = Cliente::first();

        if(!is_null($cliente)){
            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/cliente/'.$cliente->id);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    "id",
                    "grupo_id",
                    "nome",
                    "cnpj",
                    "data_fundacao",
                    "created_at",
                    "updated_at",
                    "grupo" => [
                        "id",
                        "nome",
                        "created_at",
                        "updated_at",
                    ]
                ]);
        }
    }
    
    /**
     * Insere cliente
     *
     * @return void
     */
    public function test_insere_cliente()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $payload = [
            "grupo_id" => 1,
            "nome" => "Cliente Teste",
            "cnpj" => "98.274.339/0001-80",
            "data_fundacao" => "2022-04-30"
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/cliente', $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "grupo_id",
                "nome",
                "cnpj",
                "data_fundacao",
                "created_at",
                "updated_at"
            ]);
    }

    /**
     * Insere cliente com erro
     *
     * @return void
     */
    public function test_insere_cliente_com_erro()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $payload = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/cliente', $payload);

        $response
            ->assertStatus(503)
            ->assertJsonStructure([
                'erros' => []
            ]);
    }

    /**
     * atualiza cliente
     *
     * @return void
     */
    public function test_atualiza_cliente()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $cliente = Cliente::orderBy('id', 'desc')->first();

        if(!is_null($cliente)){
            $payload = [
                'id' => $cliente->id,
                "grupo_id" => 1,
                "nome" => "Teste 123",
                "cnpj" => "96.487.679/0001-64",
                "data_fundacao" => "2015-10-18"
            ];

            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/cliente', $payload);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    "id",
                    "grupo_id",
                    "nome",
                    "cnpj",
                    "data_fundacao",
                    "created_at",
                    "updated_at"
                ]);
        }
    }

    /**
     * deleta cliente
     *
     * @return void
     */
    public function test_deleta_cliente()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $cliente = Cliente::orderBy('id', 'desc')->first();

        if(!is_null($cliente)){
            $payload = [
                'id' => $cliente->id,
            ];

            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->deleteJson('/api/cliente', $payload);

            $response
                ->assertStatus(200)
                ->assertExactJson([
                    'successo' => 'Cliente removido com sucesso'
                ]);
        }
    }
}
