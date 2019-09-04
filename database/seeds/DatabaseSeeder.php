<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        User::create([
            'nombre' => 'ADMINISTRADOR',
            'email' => 'admin@srcenter.cl',
            'password' => bcrypt('123456789'),
            'tipo_usuario' => 1
        ]);
    }
}
