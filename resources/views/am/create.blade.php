<!DOCTYPE html>
<html lang="en">
 <head>
@include('layouts.partials.head')
 </head>
 <body>
@include('layouts.partials.nav_am') 

<button type="button" class="btn btn-danger btn-lg fixed-bottom addproject">+ Ajouter projet</button>

<div class="container">
  
    <div class="col-6">

      <h2 class="title">Remplissage planning</h2>

          {{ Form::open(array('url' => 'plannings')) }}
          <!-- select box -->

          {{ Form::label('project','Projet', array('id'=>'','class'=>'col-12')) }}
          {{ Form::text('project','', array('class'=>'typeahead', 'autocomplete'=>"off")) }}
          

          {{Form::label('subtask', 'Sous-tâche', array('class' => 'col-12')) }}
          {{Form::select('subtask', array())}}

          <!-- text input field -->
          {{ Form::label('username','Username',array('class'=>'col-12')) }}
          {{ Form::text('username','Hola',array('autocomplete'=>"off",'class'=>'')) }}

          {{Form::submit('Click Me!')}}
            
          {{ Form::close() }}
</div>

<div class="offset-1 col6"></div>

</div>
   

   <script type="text/javascript">

    var path = "{{ route('autocomplete') }}";
    //console.log($('input.typeahead').typeahead('val'));
    $('input.typeahead').typeahead({
    source:  function (query, process) {
    return $.get(path, { query: query }, function (data) {
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
      return obj.id;
    }
    });
  /* .on('typeahead:selected', function($e, datum)
  {
    console.log('hola');
        }
    ); */

//var myVal = $('input.typeahead').typeahead('val');
//console.log(myVal);

</script>

</body>



      
</body>
</html>