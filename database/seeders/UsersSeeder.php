<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Gerente Nivel Um',
            'email' => 'nivel.um@dugovich.com.br',
            'level' => 1,
            'password' => Hash::make('NivelUm@1324'),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        DB::table('users')->insert([
            'name' => 'Gerente Nivel Dois',
            'email' => 'nivel.dois@dugovich.com.br',
            'level' => 2,
            'password' => Hash::make('NivelDois#1029'),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}
