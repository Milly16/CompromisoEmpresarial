<?php

use App\Company;
use App\User;
use Illuminate\Database\Seeder;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Company::create([
            'ruc' => '12345678910',
            'razonSocial' => 'Compromiso Empresarial',
            'contNombre' => 'Remso',
            'contApellido' => 'Rojas',
            'contTelefono' => '921867035',
            'disctrict_id' => '1160',
            'direccion' => 'union 1234'
        ]);

       User::create([
            'type_id' => '1',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
