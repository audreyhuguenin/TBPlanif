<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->delete();
        $subtasks= App\Subtask::pluck('id')->toArray();

for($i = 0; $i < 200; ++$i)
	{

	DB::table('tasks')->insert([
	'name' => 'Nom Tâche' . $i,
                'comment' => 'Commentaire' . $i,
	'subtask_id' => $subtasks[array_rand($subtasks)],

		]);
	}
    }
}
