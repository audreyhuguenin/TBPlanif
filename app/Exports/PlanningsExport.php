<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Planning;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlanningsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $noww = Carbon::now()->settings([
            'locale' => 'fr_FR',
            'timezone' => 'Europe/Paris',
        ]);
        $weekNum = $noww->weekOfYear;
        $startWeek= $noww->startOfWeek()->format('Y-m-d H:i');
        $endweek=$noww->startOfWeek()->addDays(5)->format('Y-m-d H:i');

        $tasks = \App\Task::join('assignations', 'tasks.id', '=', 'assignations.task_id')
        ->join('users', 'assignations.user_id', '=', 'users.id')
        ->join('subtasks', 'tasks.subtask_id', '=', 'subtasks.id')
        ->join ('projects', 'projects.number', '=', 'subtasks.project_id')
        ->whereBetween('date',[$startWeek, $endweek])
        ->select('projects.fullName',
        'subtasks.name as subtaskName',
        'users.name as userName',
        'tasks.name as taskName',
        'tasks.comment',
        'assignations.date',
        'assignations.duration', 
        'assignations.type',
        'assignations.suiviDA',
        'assignations.unmovable')
        ->distinct()
        ->get();
        return $tasks;
    }
    
    public function headings(): array
    {
        return [
            'Projet',
            'Sous-tâche',
            'Exécutant',
            'Nom de la tâche',
            'Commentaire',
            'Date',
            'Durée',
            'Type(s)',
            'suiviDA',
            'Indéplaçable'
        ];
    }
}
