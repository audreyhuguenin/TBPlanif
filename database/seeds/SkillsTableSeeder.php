<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->delete();
        DB::table('skill_user')->delete();

         $users = App\User::pluck('id');
         $last = count($users) - 1;

        $names=array("graphiste", "fort en dessin", "doué en vente", "souriant", "fatiguant");
	foreach ($names as $name)
	{
	
            $skill= App\Skill::create([
	'name' => $name,
		]);

            if (count($users))
            {
               $skill->users()->attach( $users[ rand(0, $last ) ] );
            }
	}

    }
}
