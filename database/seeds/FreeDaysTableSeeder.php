<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FreeDaysTableSeeder extends Seeder
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
        DB::table('free_days')->delete();

	for($i = 0; $i < 50; ++$i)
	{
	$startDate =  Carbon::create(2019, 5, 28, 8, 30, 0);
                $endDate =  Carbon::create(2019, 5, 28, 9, 30, 0);
	DB::table('free_days')->insert([
	'startDate' => $startDate,
	'endDate' => $endDate,
	'user_id' => rand(1, 10),
		]);
	}
    }
}
