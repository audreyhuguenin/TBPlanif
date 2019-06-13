<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();

    for($i = 0; $i < 10; ++$i)
	{
	DB::table('projects')->insert([
	'name' => 'Nom Projet' . $i,
                'number' => $i
		]);
	}
    }
}
