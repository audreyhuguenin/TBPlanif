<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AssignationsTableSeeder extends Seeder
{
    private function randDate()
	{
		return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignations')->delete();
        $users= App\User::pluck('id')->toArray();
        $tasks= App\Task::pluck('id')->toArray();

	for($i = 0; $i < 300; ++$i)
	{
	$date = $this->randDate();
	DB::table('assignations')->insert([
	'date' => $date,
	'duration' => rand(1, 8),
    'type' => '["T", "TT"]',
                'suiviDA' => rand(0, 1),
                'unmovable' => rand(0, 1),
                'task_id' => $tasks[array_rand($tasks)],
	'user_id' => $users[array_rand($users)],
		]);
	}
    }
}
