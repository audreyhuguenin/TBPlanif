@extends('layouts.mainlayout')

@section('content')

   <div class="text-muted">
     <div class="container">
     <h4 class="text-center">Planning de la semaine {{$weeknum}}, du {{$startWeek}} au {{$endWeek}}</h4>
    <table class="table table-bordered">
        <tr>
            <th> @sortablelink('project', "Projet")</th>
            <th> @sortablelink('user', 'Qui ?')</th>
            <th>Tâche</th>
            <!--calendar -->
            <th>{{$weekDays[0]}}</th>
            <th>{{$weekDays[1]}}</th>
            <th>{{$weekDays[2]}}</th>
            <th>{{$weekDays[3]}}</th>
            <th>{{$weekDays[4]}}</th>
        </tr>
        @if($tasks->count())
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->subtask->project->fullName}}</td>
                    <td>
                    @foreach($task->assignations as $assignation)
                        @if(\Carbon\Carbon::parse($assignation->date)->gt(\Carbon\Carbon::parse($startWeek))&&\Carbon\Carbon::parse($assignation->date)->lt(\Carbon\Carbon::parse($endWeek)))
                            {{$assignation->user->name}}
                        @endif
                    @endforeach

                    </td>
                        
                    <td>{{ $task->name }}</td>

                    

                    <!--calendar-->
                    <!--if assignation->date->isoFormat('ddd DD.MM') == -->
                    <td> 
                    @foreach($task->assignations as $assignation)
                        @if($assignation->date->dayOfWeek==1)
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type['value'] }}</span>
                             @endforeach
                         @endif 
                    @endforeach
                    </td>
                    <td> 
                    @foreach($task->assignations as $assignation)
                        @if($assignation->date->dayOfWeek==2)
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type['value'] }}</span>
                             @endforeach
                         @endif 
                    @endforeach
                    </td>
                    <td> 
                    @foreach($task->assignations as $assignation)
                        @if($assignation->date->dayOfWeek==3)
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type['value'] }}</span>
                             @endforeach
                         @endif 
                    @endforeach
                    </td>
                    <td> 
                    @foreach($task->assignations as $assignation)
                        @if($assignation->date->dayOfWeek==4)
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type['value'] }}</span>
                             @endforeach
                         @endif 
                    @endforeach
                    </td>
                    <td> 
                    @foreach($task->assignations as $assignation)
                        @if($assignation->date->dayOfWeek==5)
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type['value'] }}</span>
                             @endforeach
                         @endif 
                    @endforeach
                    </td> 

                    </tr>
            @endforeach
                
            
        @endif
    </table>
    
     </div>
   </div>
@endsection