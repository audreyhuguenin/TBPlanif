<?php

use Illuminate\Database\Seeder;

class SubtasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subtasks')->delete();

for($i = 0; $i < 100; ++$i)
	{
	//$date = $this->randDate();
	DB::table('subtasks')->insert([
	'name' => 'Nom Sous-Tâche' . $i,
	'project_id' => rand(1, 10),
	//'created_at' => $date,
	//'updated_at' => $date
		]);
	}
    }
}
