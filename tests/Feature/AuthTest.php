<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * Testa o login.
     *
     * @return void
     */
    public function test_login()
    {
        $param = [
            "email" => "nivel.dois@dugovich.com.br",
            "password" => "NivelDois#1029"
        ];

        $response = $this->postJson('/api/login', $param);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "token",
                "tipo",
                "expira_em"
            ]);
    }

    
    /**
     * Testa o login com dados inválidos.
     *
     * @return void
     */
    public function test_login_errado()
    {
        $param = [
            "email" => "login.errado@dugovich.com.br",
            "password" => "1234"
        ];

        $response = $this->postJson('/api/login', $param);

        $response->assertStatus(401)
            ->assertExactJson([
                "erro" => "Acesso não autorizado"
            ]);
    }


    /**
     * Testa o logout.
     * 
     * @return void
     */
    public function test_logout()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "message" => "Logout realizado com sucesso"
            ]);
    }


    /**
     * Mostra gerente logado.
     * 
     * @return void
     */
    public function test_gerente()
    {
        $user = User::where('email', "nivel.um@dugovich.com.br")->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/gerente');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "nome",
                "email",
                "nível",
                "criado_em",
                "atualizado_em"
            ]);
    }
}
