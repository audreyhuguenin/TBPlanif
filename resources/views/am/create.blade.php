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

          {{ Form::label('project','Projet', array('id'=>'','class'=>'col-12')) }}
          {{ Form::text('project_typeahead','', array('class'=>'projecttypeahead', 'autocomplete'=>"off")) }}
          {{ Form::hidden('project','', array('id'=>'project_id')) }}       
          <div class="row">
          <div class="col-3">
          {{Form::label('subtask', 'Sous-tâche', array('class' => 'col-12')) }}
          {{Form::select('subtask', array())}}
          </div>
          <div class="col-9" id="tasks">
                <div class="row">
                    <div class="col-9">
                              {{ Form::label('task_name','Nom de la tâche',array('class'=>'col-12')) }}
                              {{ Form::text('task_name','',array('autocomplete'=>"off",'class'=>'')) }}
                    </div>
                <div class="col-3">
            {{ Form::label('comment','Commentaire ?', array('id'=>'','class'=>'col-12')) }}
            {{ Form::text('comment','', array('class'=>'comment', 'autocomplete'=>"off")) }}
                </div>

                </div>

          {{ Form::label('user','Qui qui doit faire?', array('id'=>'','class'=>'col-12')) }}
          {{ Form::text('user_typeahead','', array('class'=>'usertypeahead', 'autocomplete'=>"off")) }}
          {{ Form::hidden('user','', array('id'=>'user_id')) }}   

          
          <button onclick="addTask()">Add New Field </button>
          </div>

      


          </div>   

          {{Form::submit('Click Me!')}}
            
          {{ Form::close() }}
</div>

<div class="offset-1 col6"></div>

</div>
   

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
      $('#user_id').val(obj.id);
      return obj ;
    },   
});
</script>

</body>



      
</body>
</html>