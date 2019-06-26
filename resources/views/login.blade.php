<!DOCTYPE html>
<html lang="en">
 <head>
@include('layouts.partials.head')
 </head>
 <body>
@if (session('error'))
<div class="alert alert-danger" role="alert">
  Nope. Réessaie.
</div>
@endif
@if (session('loginRequired'))
<div class="alert alert-warning" role="alert">
 Il faut d'abord que tu te connectes.
</div>
@endif


<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first icon">
      <img src="https://image.flaticon.com/icons/png/128/149/149305.png" id="icon" alt="login Icon"/>
    </div>

    <!-- Login Form -->
    <form action="{{ action('AuthController@check') }}" method="post">
    @csrf
      <input type="text" id="login" class="fadeIn second" name="email" placeholder="prénom.nom">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Ton mot de passe">
      <input type="submit" class="fadeIn fourth" value="Go!">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover forgot" href="#" >Mot de passe oublié? </a>
      <p class="hidden toobad">Dommage, tu vas devoir plonger dans NAV.</p>
    </div>

  </div>
</div>

@include('layouts.partials.footer-scripts')

</body>
</html>



