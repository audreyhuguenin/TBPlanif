<!DOCTYPE html>
<html lang="en">
 <head>
@include('layouts.partials.head')

 </head>
 <body>
@include('layouts.partials.nav_am') 

<button type="button" class="btn btn-danger btn-lg fixed-bottom addproject">+ Ajouter projet</button>

<div class="container">
  
    <div class="col-12">

      <h2 class="title">Remplissage planning</h2>

          {{ Form::open(array('url' => 'plannings')) }}
          <!-- select box -->

         
          {{ Form::text('project_typeahead','', array('class'=>'projecttypeahead', 'autocomplete'=>"off", 'placeholder'=>'Choisis le projet')) }}
          {{ Form::hidden('project','', array('id'=>'project_id')) }}       
          <div class="row">
          <div class="col-3">
          
          {{Form::select('subtask', array('placeholder'=>'Sous-tâche', 'id'=>'subtask'))}}
          </div>
          <div class="col-9" id="tasks">
            <div class="task">
                <div class="row">
                  <button class="remove_button btn btn-danger col-1"><i class="fas fa-trash-alt"></i></button>
                  <div class="row col-11">
                      <div class="col-9">
                          {{ Form::text('task_name','',array('autocomplete'=>"off",'class'=>'', 'placeholder'=>'Nom de la tâche')) }}
                      </div>
                      <div class="col-3">
                          {{ Form::text('comment','', array('class'=>'comment', 'autocomplete'=>"off", 'placeholder'=>'comment')) }}
                      </div>
                          {{ Form::text('user_typeahead','', array('class'=>'usertypeahead', 'autocomplete'=>"off", 'placeholder'=>'Qui qui doit faire?')) }}
                          {{ Form::hidden('user','', array('class'=>'user_id')) }}   
                  </div>
                </div>
            </div>
          </div>
          <button class="add_task btn btn-danger">+ Add new task</button>
          </div>   

          {{Form::submit('Click Me!')}}
            
          {{ Form::close() }}
</div>

<div class="offset-1 col6"></div>

</div>
   


    <script src="{{asset('/js/login.js')}}"></script>
    <script src="{{asset('/js/planning.js')}}"></script>

   <script type="text/javascript">

    var pathproject = "{{ route('projectautocomplete') }}";
    //console.log($('input.typeahead').typeahead('val'));
    $('input.projecttypeahead').typeahead({
    source:  function (query, process) {
    return $.get(pathproject, { query: query }, function (data) {
            return process(data);
            });
    },
    updater: function(obj){
      console.log("hola");
      var subtasks = $.get("{{route('subtasks.index')}}", {"project_id":obj.name}, function(data){
        console.log(data);
        $('#subtask').find('option')
                    .remove()
                    .end();
        data.forEach(function(e, i){
          $('#subtask').append($('<option></option>')
                      .val(e.id)
                      .text(e.name)); 
        });

      });
      $('#project_id').val(obj.id);
      return obj ;
    },   
});

var pathuser = "{{ route('userautocomplete') }}";
    //console.log($('input.typeahead').typeahead('val'));
    $('input.usertypeahead').typeahead({
    source:  function (query, process) {
    return $.get(pathuser, { query: query }, function (data) {
            return process(data);
            });
    },
    updater: function(obj){  
      $('.user_id').val(obj.id);
      return obj ;
    },   
});


</script>


</body>
</html>