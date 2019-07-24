<!DOCTYPE html>
<html lang="en">
 <head>
@include('layouts.partials.head')
 </head>
 <body>
@include('layouts.partials.nav_crea') 

   <div class="text-muted">
     <div class="container">
     <h4 class="text-center">Planning de la semaine {{$weeknum}}, du {{$startWeek}} au {{$endWeekDisplayed}}</h4>
    <table class="table table-bordered">
        <tr>
            <th> @sortablelink('fullName', "Projet")</th>
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
        <tr class="hovered">
                    <td>{{$task->subtask->project->fullName}}</td>
                    <td>
                    @php
                    $user = \App\User::find($task->user_id);
                    echo $user->name;
                   @endphp
                    </td>
                        
                    <td class="taskname">{{ $task->name }}</td>

                    <!--calendar-->
                    <!--if assignation->date->isoFormat('ddd DD.MM') == -->
                    <td class="calendar"> 
                    @foreach($task->assignations as $assignation)
                    @if(\Carbon\Carbon::parse($assignation->date)->gt(\Carbon\Carbon::parse($startWeek))
                    &&\Carbon\Carbon::parse($assignation->date)->lt(\Carbon\Carbon::parse($endWeek))
                    && $assignation->date->dayOfWeek===1
                    && $assignation->user_id==$user->id)
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type }}</span>
                            @endforeach
                            @if($assignation->suiviDA)
                             <i class="fas fa-anchor"></i>
                            @endif
                         @endif 
                    @endforeach
                    </td>
                    <td class="calendar"> 
                    @foreach($task->assignations as $assignation)
                    @if(\Carbon\Carbon::parse($assignation->date)->gt(\Carbon\Carbon::parse($startWeek))
                    &&\Carbon\Carbon::parse($assignation->date)->lt(\Carbon\Carbon::parse($endWeek))
                    && $assignation->date->dayOfWeek===2
                    && $assignation->user_id==$user->id)
                   
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type }}</span>
                             @endforeach

                             @if($assignation->suiviDA)
                             <i class="fas fa-anchor"></i>
                             @endif
                         @endif 
                    @endforeach
                    </td>
                    <td class="calendar"> 
                    @foreach($task->assignations as $assignation)
                    @if(\Carbon\Carbon::parse($assignation->date)->gt(\Carbon\Carbon::parse($startWeek))
                    &&\Carbon\Carbon::parse($assignation->date)->lt(\Carbon\Carbon::parse($endWeek))
                    && $assignation->date->dayOfWeek===3
                    && $assignation->user_id==$user->id)
                
                    @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type }}</span>
                             @endforeach
              
                             @if($assignation->suiviDA)
                             <i class="fas fa-anchor"></i>
                             @endif
                         @endif 
                    @endforeach
                    </td>
                    <td class="calendar"> 
                    @foreach($task->assignations as $assignation)
                    @if(\Carbon\Carbon::parse($assignation->date)->gt(\Carbon\Carbon::parse($startWeek))
                    &&\Carbon\Carbon::parse($assignation->date)->lt(\Carbon\Carbon::parse($endWeek))
                    && $assignation->date->dayOfWeek===4
                    && $assignation->user_id==$user->id)
                 
                    @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">{{ $type }}</span>
                             @endforeach
              
                             @if($assignation->suiviDA)
                             <i class="fas fa-anchor"></i>
                             @endif
                         @endif 
                    @endforeach
                    </td>
                    <td class="calendar"> 
                    @foreach($task->assignations as $assignation)
                    @if(\Carbon\Carbon::parse($assignation->date)->gt(\Carbon\Carbon::parse($startWeek))
                    &&\Carbon\Carbon::parse($assignation->date)->lt(\Carbon\Carbon::parse($endWeek))
                    && $assignation->date->dayOfWeek===5
                    && $assignation->user_id==$user->id)
                 
                            @foreach($assignation->type as $type)
                                <span class="badge badge-pill badge-danger">type {{ $type }}</span>
                             @endforeach
                  
                             @if($assignation->suiviDA)
                             <i class="fas fa-anchor"></i>
                             @endif
                         @endif
                    @endforeach
                    </td> 
            </tr>
            @endforeach
        @endif
        <tr>
          <td> </td>
          <td> </td>
          <td> </td>
            @foreach ($durationPerDay as $duration)
            <td>
                <p class="totalDuration">Heures totales: {{$duration}}</p>
            </td>
            @endforeach
        </tr>
    </table>
    
     </div>
   </div>
   @include('layouts.partials.footer')
@include('layouts.partials.footer-scripts')
 </body>
</html>