<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Grupo;

class GrupoTest extends TestCase
{
    /**
     * Listar grupos
     *
     * @return void
     */
    public function test_grupos()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/grupos');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "id",
                    "nome",
                    "created_at",
                    "updated_at",
                ]
            ]);
    }
    
    /**
     * detalhes de um grupo
     *
     * @return void
     */
    public function test_grupo_detalhes()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $grupo = Grupo::first();

        if(!is_null($grupo)){
            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/grupo/'.$grupo->id);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    "id",
                    "nome",
                    "created_at",
                    "updated_at",
                    "clientes" => [
                        '*' => [
                            "id",
                            "grupo_id",
                            "nome",
                            "cnpj",
                            "data_fundacao",
                            "created_at",
                            "updated_at",
                        ]
                    ]
                ]);
        }
    }

    /**
     * Insere grupo com gerente de nível 1
     *
     * @return void
     */
    public function test_insere_grupo_n1()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $payload = [
            'nome' => 'Teste'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/grupo', $payload);

        $response
            ->assertStatus(401)
            ->assertExactJson([
                'erro' => 'Nível não autorizado'
            ]);
    }

    /**
     * atualiza grupo com gerente de nível 1
     *
     * @return void
     */
    public function test_atualiza_grupo_n1()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $grupo = Grupo::orderBy('id', 'desc')->first();

        if(!is_null($grupo)){
            $payload = [
                'id' => $grupo->id,
                'nome' => 'Teste 123'
            ];

            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/grupo', $payload);

            $response
                ->assertStatus(401)
                ->assertExactJson([
                    'erro' => 'Nível não autorizado'
                ]);
        }
    }

    /**
     * deleta grupo com gerente de nível 1
     *
     * @return void
     */
    public function test_deleta_grupo_n1()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $grupo = Grupo::orderBy('id', 'desc')->first();

        if(!is_null($grupo)){
            $payload = [
                'id' => $grupo->id,
            ];

            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->deleteJson('/api/grupo', $payload);

            $response
                ->assertStatus(401)
                ->assertExactJson([
                    'erro' => 'Nível não autorizado'
                ]);
        }
    }
    
    /**
     * Insere grupo com gerente de nível 2
     *
     * @return void
     */
    public function test_insere_grupo_n2()
    {
        $user = User::where('email', "nivel.dois@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $payload = [
            'nome' => 'Grupo Teste'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/grupo', $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "nome",
                "created_at",
                "updated_at"
            ]);
    }

    /**
     * Insere grupo com erro com gerente de nível 2
     *
     * @return void
     */
    public function test_insere_grupo_com_erro_n2()
    {
        $user = User::where('email', "nivel.dois@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $payload = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/grupo', $payload);

        $response
            ->assertStatus(503)
            ->assertJsonStructure([
                'erros' => []
            ]);
    }

    /**
     * atualiza grupo com gerente de nível 2
     *
     * @return void
     */
    public function test_atualiza_grupo_n2()
    {
        $user = User::where('email', "nivel.dois@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $grupo = Grupo::orderBy('id', 'desc')->first();

        if(!is_null($grupo)){
            $payload = [
                'id' => $grupo->id,
                'nome' => 'Teste 123'
            ];

            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/grupo', $payload);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    "id",
                    "nome",
                    "created_at",
                    "updated_at"
                ]);
        }
    }

    /**
     * deleta grupo com gerente de nível 2
     *
     * @return void
     */
    public function test_deleta_grupo_n2()
    {
        $user = User::where('email', "nivel.dois@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $grupo = Grupo::orderBy('id', 'desc')->first();

        if(!is_null($grupo)){
            $payload = [
                'id' => $grupo->id,
            ];

            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->deleteJson('/api/grupo', $payload);

            $response
                ->assertStatus(200)
                ->assertExactJson([
                    'successo' => 'Grupo removido com sucesso'
                ]);
        }
    }
}
