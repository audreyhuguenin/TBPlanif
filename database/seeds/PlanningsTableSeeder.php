<?php

use Illuminate\Database\Seeder;

class PlanningsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plannings')->delete();
        DB::table('planning_project')->delete();

        $projects = App\Project::pluck('id');
        $last = count($projects) - 1;
        $users= App\User::pluck('id')->toArray();

            for($i = 0; $i < 100; ++$i)
	{

	$planning = App\Planning::create([
            	'sent' => rand(0, 1),
                'user_id' => $users[array_rand($users)],
		]);

        if (count($projects))
            {
               $planning->projects()->attach( $projects[ rand(0, $last ) ] );
            }
	}
    }
}
