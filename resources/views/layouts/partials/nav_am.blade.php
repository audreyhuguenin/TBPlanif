   <div class="navbar navbar-inverse bg-inverse">
     <div class="container d-flex justify-content-between">
        <img src= {{asset('img/logo.png')}} class="float-left" alt="Creatives logo">
        <button type="button" class="btn btn-outline-danger"> Je sauvegarde !</button>
        <button type="button" class="btn btn-outline-danger">Envoyer !</button>
        <div class="logout">
            <p>{{$userInfo}} <i class="fas fa-long-arrow-alt-down"></i></p>
               <div class="logout-button">
                  <a href="/" class="">Accueil  <i class="fas fa-igloo"></i></a>
                  <a href="auth/logout" class="">I'm out  <i class="fas fa-dragon"></i> </a>
               </div>
      </div>
     </div>
   </div>