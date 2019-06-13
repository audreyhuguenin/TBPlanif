<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(SubtasksTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(AssignationsTableSeeder::class);
        $this->call(FreeDaysTableSeeder::class);
        $this->call(RecurrentFreeDaysTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        $this->call(PlanningsTableSeeder::class);
    }
}
