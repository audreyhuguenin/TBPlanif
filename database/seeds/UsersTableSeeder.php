<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

DB::table('users')->delete();

    for($i = 0; $i < 10; ++$i)
	{
	DB::table('users')->insert([
	'firstName' => 'Prenom' . $i,
                'lastName' => 'Nom' . $i,
	'email' => 'email' . $i . '@gmaiil.fr',
	'password' => bcrypt('password' . $i),
                'contractRate' => 80
		]);
	}
        }

}
