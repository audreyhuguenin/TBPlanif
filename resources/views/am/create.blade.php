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
        <h2 class="title">Remplissage planning</h2>
        <div class="projects">
            <div class="project" style="border-bottom: 1px lightgray solid;">
                <div class="row">
                    <a class="remove_project" style="margin-top:10px;"><i class="fas fa-times"></i></a>
                    <div class="col-11">
                        {{ Form::text('project_typeahead','', array('class'=>'projecttypeahead', 'autocomplete'=>"off", 'placeholder'=>'Choisis le projet')) }}
                        {{ Form::hidden('project','', array('class'=>'project_id')) }}
                    </div>
                </div>
                <div class="subtasks">
                    <div class="subtask">
                        <div class="row">
                            <a class="remove_sub" style="margin-top:10px;"><i class="fas fa-times"></i></a>
                            <div class="col-3">
                                {{Form::select('subtask', array('placeholder'=>'Sous-tâche'))}}
                            </div>
                            <div class="col-8">
                                <div class="tasks">
                                    <div class="task">
                                        <div class="row">
                                            <button class="remove_button btn btn-danger col-1"><i
                                                    class="fas fa-trash-alt"></i></button>
                                            <div class="row col-11">

                                                {{ Form::text('task[task1][task_name]','',array('autocomplete'=>"off",'class'=>'', 'placeholder'=>'Nom de la tâche')) }}
                                                {{ Form::text('task[task1][comment]','', array('class'=>'comment', 'autocomplete'=>"off", 'placeholder'=>'comment')) }}

                                                {{ Form::text('user_typeahead','', array('class'=>'usertypeahead', 'autocomplete'=>"off", 'placeholder'=>'Qui qui doit faire?')) }}
                                                {{ Form::hidden('task[task1][user]','', array('class'=>'user_id')) }}
                                            </div>
                                        </div>
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
                    $this.parent().parent().parent().find('select[name=subtask]').find('option')
                        .remove()
                        .end();
                    data.forEach(function (e, i) {
                      $this.parent().parent().parent().find('select[name=subtask]').append($('<option></option>')
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
