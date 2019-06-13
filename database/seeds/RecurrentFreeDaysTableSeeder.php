<?php

use Illuminate\Database\Seeder;

class RecurrentFreeDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recurrent_free_days')->delete();
        DB::table('recurrent_free_days_user')->delete();

        $users = App\User::pluck('id');
         $last = count($users) - 1;

        $days=array("lundi", "mardi", "mercredi", "jeudi", "vendredi");



	foreach ($days as $day)
	{
            $recFreeDay= App\RecurrentFreeDay::create([
	'jour' => $day,
		]);

            if (count($users))
            {
               $recFreeDay->users()->attach( $users[ rand(0, $last ) ] );
            }
	}
    }
}
