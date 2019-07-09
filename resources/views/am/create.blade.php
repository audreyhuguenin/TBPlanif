<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.partials.head')

</head>

<body>
    {{ Form::open(array('url' => 'plannings')) }}
    @include('layouts.partials.nav_am')

    <button type="button" class="btn btn-danger btn-lg fixed-bottom add_project">+ Ajouter projet</button>


    <div class="container">
        <h2 class="title">Remplissage planning de la semaine {{$weeknum}}, du {{$startWeek}} au {{$endWeek}}</h2>
        <div class="projects">
            <div class="project" style="border-bottom: 1px lightgray solid;">
                <div class="row">
                    <a class="remove_project" style="margin-top:10px;"><i class="fas fa-times"></i></a>
                    <div class="col-11">
                        {{ Form::text('project_typeahead','', array('class'=>'projecttypeahead', 'autocomplete'=>"off", 'placeholder'=>'Choisis le projet')) }}
                        {{ Form::hidden('project[1]','', array('class'=>'project_id')) }}
                    </div>
                </div>
                <div class="subtasks">
                    <div class="subtask">
                        <div class="row">
                            <a class="remove_sub" style="margin-top:10px;"><i class="fas fa-times"></i></a>
                            <div class="col-3">
                            <select name="project[1][subtask][1][subtask_id]" class="subtask_id"><option value="placeholder">Sous-tâche</option></select>
                            </div>
                            <div class="col-8">
                                <div class="tasks ">
                                    <div class="task row">
                                        <div class="row col-7">
                                            <button class="remove_button btn btn-danger col-1"><i
                                                    class="fas fa-trash-alt"></i></button>
                                            <div class="row col-11">

                                                {{ Form::text('project[1][subtask][1][task][1][task_name]','',array('autocomplete'=>"off",'class'=>'col-10', 'placeholder'=>'Nom de la tâche')) }}
                                                <div class="comment">
							                        <button class="toggle_comment_box"><i class="far fa-comment"></i></button>
                                                    <div class="comment_box">
                                                        <textarea maxlength="250" class="comment_text comment" autocomplete="off" placeholder="Ton commentaire (facultatif)" name="project[1][subtask][1][task][1][comment]"></textarea>
                                                        <button class="validate btn btn-outline-dark">Ok</button>
                                                    </div>
						                        </div>
                                                {{ Form::text('user_typeahead','', array('class'=>'usertypeahead', 'autocomplete'=>"off", 'placeholder'=>'Qui qui doit faire?')) }}
                                                {{ Form::hidden('project[1][subtask][1][task][1][user]','', array('class'=>'user_id')) }}
                                            </div>
                                            </div>
                                            <table class="assignations table table-bordered col-5">
                                                <tr>
                                                    <!--calendar -->
                                                    <th>{{$weekDays[0]}}</th>
                                                    <th>{{$weekDays[1]}}</th>
                                                    <th>{{$weekDays[2]}}</th>
                                                    <th>{{$weekDays[3]}}</th>
                                                    <th>{{$weekDays[4]}}</th>
                                                </tr>
                                                <tr>
                                                    <td class="mo"><i class="fas fa-plus assignation_button"></i>
                                                        <div class="assignation_form">
                                                        {{ Form::checkbox('suiviDA', 'true', array('class'=>'')) }}
                                                        {{ Form::label('suiviDA', 'Suivi DA') }}
                                                        {{Form::number('duration', ' ', array('placeholder'=>'durée en heure', 'max'=>8))}}
                                                        {{ Form::label('type', 'Quel(s) type(s) ?') }}
                                                        <div class="row">
                                                            <div class="col-3">
                                                            {{ Form::checkbox('type[B]', 'value','true', array('class'=>'')) }}
                                                            {{ Form::label('type', 'B') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[D]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'D') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[RC]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'RC') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[PC]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'PC') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[L]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'L') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[RDV]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'RDV') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[BO]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'BO') }}
                                                            </div>
                                                            <div class="col-3">
                                                        {{ Form::checkbox('type[RG]', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('type', 'RG') }}
                                                            </div>
                                                        </div>
                                                        {{ Form::checkbox('unmovable', 'value','true', array('class'=>'')) }}
                                                        {{ Form::label('unmovable', 'Indéplaçable ?') }}
                                                        
                                                        <button class="validate btn btn-outline-dark">Ok</button>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="tu"></td>
                                                    <td class="we"></td>
                                                    <td class="th"></td>
                                                    <td class="fr"></td>
                                                </tr>
                                            </table>    
                                    </div>
                                        
                                </div>
                                <button class="add_task btn btn-danger">+ Add new task</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="add_subtask btn btn-danger">+ Add subtask</button>

                {{ Form::close() }}
            </div>
        </div>

    </div>
    <script src="{{asset('/js/login.js')}}"></script>
    <script src="{{asset('/js/planning.js')}}"></script>

    <script type="text/javascript">
        var pathproject = "{{ route('projectautocomplete') }}";
        //console.log($('input.typeahead').typeahead('val'));
        $('input.projecttypeahead').each(function(index){
          var $this = $(this);  
       $this.typeahead({
            source: function (query, process) {
                return $.get(pathproject, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            },
            updater: function (obj) {
                var subtasks = $.get("{{route('subtasks.index')}}", {
                    "project_id": obj.name
                }, function (data) {
                    console.log(obj);
                    $this.parent().parent().parent().find('select.subtask_id').find('option')
                        .remove()
                        .end();
                    data.forEach(function (e, i) {
                      $this.parent().parent().parent().find('select.subtask_id').append($('<option></option>')
                            .val(e.id)
                            .text(e.name));
                    });

                });
                $('.project_id').val(obj.id);
                return obj;
            },
        })
      });

        var pathuser = "{{ route('userautocomplete') }}";
        //console.log($('input.typeahead').typeahead('val'));
        $('input.usertypeahead').each(function (index) {
            $(this).typeahead({
                source: function (query, process) {
                    return $.get(pathuser, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });

                },
                updater: function (obj) {
                    $('.user_id').val(obj.id);
                    return obj;
                },
            });
        });

    </script>


</body>
<footer class="footerAM">
</footer>

</html>
