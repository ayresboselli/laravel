<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Particulares
        DB::table('clientes')->insert([
            'grupo_id' => 1,
            'nome' => 'Fazenda Santa Fé',
            'cnpj' => '11.980.203/0001-08',
            'data_fundacao' => '2001-01-23',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        DB::table('clientes')->insert([
            'grupo_id' => 1,
            'nome' => 'Depósito deConstrução',
            'cnpj' => '62.633.682/0001-27',
            'data_fundacao' => '2006-08-15',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // Oficinas
        DB::table('clientes')->insert([
            'grupo_id' => 2,
            'nome' => 'Oficina Trucão',
            'cnpj' => '45.657.635/0001-02',
            'data_fundacao' => '2016-10-05',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        DB::table('clientes')->insert([
            'grupo_id' => 2,
            'nome' => 'Oficina do Zé',
            'cnpj' => '78.384.654/0001-53',
            'data_fundacao' => '208-05-03',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        // Prestadores de Serviços
        DB::table('clientes')->insert([
            'grupo_id' => 3,
            'nome' => 'Viagens Tur',
            'cnpj' => '49.667.353/0001-39',
            'data_fundacao' => '2020-02-08',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        DB::table('clientes')->insert([
            'grupo_id' => 3,
            'nome' => 'Trans Brasil',
            'cnpj' => '49.667.353/0001-39',
            'data_fundacao' => '1995-06-28',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        DB::table('clientes')->insert([
            'grupo_id' => 3,
            'nome' => 'Jóia Fretes',
            'cnpj' => '35.629.797/0001-75',
            'data_fundacao' => '2015-12-03',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}
