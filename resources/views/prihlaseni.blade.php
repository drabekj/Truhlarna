@extends('master')

@section('title', 'Prihlaseni')

@section('content')
    
<section class="form-group">

<form name="login" method="post" accept-charset="utf-8" action="rozcesti.php">
  <!-- dotaz na databazi zda jsou udaje v databazi + prejit na dalsi stranku rozcesti.php -->
  Uživatelské jméno:<br>
  <input class="form-control" type="username" name="username" placeholder="Uživatelské jméno" required><br>
  Heslo:<br>
  <input class="form-control" type="password" name="password" placeholder="Heslo" required><br><br>
  <input class="btn btn-primary" type="submit" name="login" value="Přihlaš"></form>
  

</section>


@stop