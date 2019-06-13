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

	for($i = 0; $i < 300; ++$i)
	{
	$date = $this->randDate();
	DB::table('assignations')->insert([
	'date' => $date,
	'duration' => rand(1, 8),
                'type' => '{"type": [
                                    {"value": "PC"},
                                    {"value": "RDV"},
                                    {"value": "L"}
                                 ]}',
                'suiviDA' => rand(0, 1),
                'unmovable' => rand(0, 1),
                'task_id' => rand(1, 200),
	'user_id' => rand(1, 10),
		]);
	}
    }
}
