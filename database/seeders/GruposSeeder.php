<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupos')->insert([ 'nome' => 'Particulares', 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d') ]);
        DB::table('grupos')->insert([ 'nome' => 'Oficinas', 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d') ]);
        DB::table('grupos')->insert([ 'nome' => 'Prestadores de Serviços', 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d') ]);
    }
}
