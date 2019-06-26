<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title> @yield('title')</title>
   
    <!-- CSS + Font -->
    <link href="..." type="text/css" rel="stylesheet" media="screen,projection"/>
  
    <!-- Custom CSS -->
    @yield('custom_css')    
</head>

<body>
   @yield('title')

  <footer>
   
  </footer>

  <!--  Scripts-->
  <script src="{{asset('js/jquery.js')}}"></script>
  @yield('scripts')   
</body>
</html>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>yield()</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
  <div class="container">
    @yield('main')
  </div>
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>

