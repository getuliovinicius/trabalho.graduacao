<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(
            [
                'name' => 'Super Usuário',
                'description' => 'Gerência usuários com papel Administrador'
            ],
            [
                'name' => 'Administrador',
                'description' => 'Gerência usuários com papel Gerente'
            ],
            [
                'name' => 'Super Usuário',
                'description' => 'Acessa relatórios gerenciais da aplicação'
            ],
            [
                'name' => 'Super Usuário',
                'description' => 'Usuário do serviço'
            ]
        );
    }
}
