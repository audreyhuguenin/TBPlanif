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

                                                {{ Form::text('project[1][subtask][1][task][1][task_name]','',array('autocomplete'=>"off",'class'=>'task_name col-10', 'placeholder'=>'Nom de la tâche')) }}
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
                                                        <div>
                                                                <label class="type">Suivi DA
                                                                    <input type="checkbox" class="suiviDA" name="project[1][subtask][1][task][1][assignations][1][suiviDA]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                        </div>
                                                        <input placeholder="durée en heure" max="8" class="duration" name="project[1][subtask][1][task][1][assignations][1][duration]" type="number">
                                                        <label for="type">Quel(s) type(s) ?</label>
                                                        <div class="row types">
                                                            <div class="col-3">
                                                                <label class="type">B
                                                                    <input type="checkbox" class="typeB" name="type[B]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">D
                                                                    <input type="checkbox" class="typeD" name="type[D]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">RC
                                                                    <input type="checkbox" class="typeRC" name="type[RC]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">PC
                                                                    <input type="checkbox" class="typePC" name="type[PC]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">L
                                                                    <input type="checkbox" class="typeL" name="type[L]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">RDV
                                                                    <input type="checkbox" class="typeRDV" name="type[RDV]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">BO
                                                                    <input type="checkbox" class="typeBO" name="type[BO]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <label class="type">RG
                                                                    <input type="checkbox" class="typeRG" name="type[RG]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>     
                                                            </div>                                                  
                                                            <div class="">
                                                                <label class="type"> Indéplaçable ?
                                                                    <input type="checkbox" class="unmovable" name="unmovable">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            
                                                        <button class="validate btn btn-outline-success assignation_ok col-7">Ok</button>
                                                        <button class="validate btn btn-outline-dark assignation_cancel col-4">Nope</button>

                                                    </td>
                                                    
                                                    <td class="tu"><i class="fas fa-plus assignation_button"></i></td>
                                                    <td class="we"><i class="fas fa-plus assignation_button"></i></td>
                                                    <td class="th"><i class="fas fa-plus assignation_button"></i></td>
                                                    <td class="fr"><i class="fas fa-plus assignation_button"></i></td>
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
