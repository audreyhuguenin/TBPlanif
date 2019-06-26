@extends('base')
@section('content')
@if (session('error'))
    <h1>Login failed !</h1>
@endif
@if (session('loginRequired'))
    <h1>Login required !</h1>
@endif

<form method="POST" action="{{ action('AuthController@check') }}">
    @csrf
    <input type="text" placeholder="emmmail" name="email">
    <input type="password" placeholder="password" name="password">
    <input type="submit" value="login">
 </form>
@endsection
