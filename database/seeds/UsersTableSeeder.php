<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_hash = today();

        User::create(
            [
                'name' => 'root',
                'email' => 'root@localhost',
                'password' => bcrypt('123456'),
                'account_hash' => bcrypt($account_hash)
            ]
        );
    }
}
