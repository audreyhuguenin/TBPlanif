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
        <a href="#" class=" col-2 buttonHome">
            <h3>Voir le planning de la semaine</h3>
            <i class="fas fa-road"></i>
        </a>
        <a href="#" class=" col-4 buttonHome">
            <h1>Planning global</h1>
            <p>- voir, modifier, valider semaine prochaine</p>
            <i class="fas fa-dragon"></i>
        </a>
        <a href="#" class="col-3 buttonHome"> 
            <h1>Remplir la semaine prochaine</h1>
            <i class="fas fa-puzzle-piece"></i>
        </a>
        <a href="#" class=" col-2 buttonHome">
            <h3>Modifier les congés des gens</h3>
            <i class="fas fa-umbrella-beach"></i>
        </a>
  </div>
</div>
</body>
</html>