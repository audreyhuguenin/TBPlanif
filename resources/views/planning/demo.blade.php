@extends('layouts.mainlayout')

@section('content')

   <div class="text-muted">
     <div class="container">
     <h4 class="text-center">Planning de la semaine {{$weeknum}}, du {{$startWeek}} au {{$endWeek}}</h4>
    <table class="table table-bordered">
        <tr>
            <th>@sortablelink('project', "Projet")</th>
            <th>@sortablelink('user.name', 'Qui ?')</th>
            <th>Tâche</th>
            <th>Assignation</th>
        </tr>
        @if($assignations->count())
            @foreach($assignations as $assignation)
                <tr>
                    <td width="350px">{{ $assignation->task->subtask->project->fullName}}</td>
                    <td>{{ $assignation->user->name}}</td>
                    <td>{{ $assignation->task->name }}</td>
                    <td>{{ $assignation->type }}</td>
                </tr>
            @endforeach
            
        @endif
    </table>
    {!! $assignations->appends(\Request::except('page'))->render() !!}
     </div>
   </div>
@endsection