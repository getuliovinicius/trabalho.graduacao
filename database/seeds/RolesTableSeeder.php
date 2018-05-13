<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Usuário',
                'description' => 'Gerência usuários com papel Administrador'
            ],
            [
                'name' => 'Administrador',
                'description' => 'Gerência usuários com papel Gerente'
            ],
            [
                'name' => 'Gerente',
                'description' => 'Acessa relatórios gerenciais da aplicação'
            ],
            [
                'name' => 'Usuário',
                'description' => 'Usuário do serviço'
            ]
        ]);
    }
}
