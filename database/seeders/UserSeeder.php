<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Jhonny',
            'last_name' => 'Ribeiro',
            'email' => 'jhonny@conectatecnologia.com.br',
            'password' => bcrypt('pass')
        ]);
    }
}
