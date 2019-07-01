<!DOCTYPE html>
<html lang="en">
 <head>
@include('layouts.partials.head')
 </head>
 <body>
@include('layouts.partials.nav') 

<div class="container home">
    <h1 class="titleHome">Tu veux faire quoi??</h1>
    
    <div class="row justify-content-around">
        <a href="/plannings" class=" col-5 buttonHome">
            <h1>Voir le planning de la semaine</h1>
            <i class="fas fa-road"></i>
        </a>
        <a href="/plannings/create" class="col-5 buttonHome"> 
            <h1>Remplir la semaine prochaine</h1>
            <i class="fas fa-puzzle-piece"></i>
        </a>
  </div>
</div>
</body>
</html>