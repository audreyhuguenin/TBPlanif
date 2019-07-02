<!DOCTYPE html>
<html lang="en">
 <head>
@include('layouts.partials.head')
 </head>
 <body>
@include('layouts.partials.nav_am') 

<button type="button" class="btn btn-danger btn-lg fixed-bottom addproject">+ Ajouter projet</button>

<div class="container">
  
    <div class="col-5">

      <h2 class="title">Remplissage planning</h2>

          {{ Form::open(array('url'=>'form-submit')) }}
          <!-- select box -->

          {{ Form::label('project','Projet',array('id'=>'','class'=>'')) }}
          <input name= "project" class="typeahead form-control" style="margin:0px auto;width:300px;" type="text">


<!-- text input field -->
{{ Form::label('username','Username',array('id'=>'','class'=>'')) }}
{{ Form::text('username','Hola',array('id'=>'','class'=>'')) }}
  
{{ Form::close() }}
</div>

<div class="offset-1 col6"></div>

</div>
   

   <script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
    source:  function (query, process) {
    return $.get(path, { query: query }, function (data) {
            return process(data);
        });
    }
});
</script>

</body>



      
</body>
</html>