@extends('master')

@section('title', 'Rozcestí')

@section('loggedAs')

<?php
$accountType = "Karel (admin)";
echo "<p class='navbar-brand' float='right'>Přihlášen jako: " . $accountType;
?>
</p>
@stop

@section('content')

<style type="text/css">
    .skryte{
        display:none;
    }

    ul:hover .skryte{
        display: block;
    }
</style>

<p id="accountType">
<div class="container">
  <div class="visible_for_all">
    <div class="col-md-4 col-md-offset-4 pagination-centered">
        <ul list-style-type='none'>
            <li class="show"><a href="{{action('RozcestiController@pracovniVykaz')}}"
            class="btn btn-primary btn-lg btn-block">Vyplnění pracovního výkazu</a></li>
            <li class="skryte"><input type="username" name="username" placeholder="Uživatelské ID" required></li>
            <li class="skryte"><input type="username" name="datumPracvykaz" placeholder="Datum" required></li>
        </ul>

        <!--<ul><button type = "submit" class = "btn btn-primary btn-lg btn-block">Generování úkolové mzdy</button></ul>-->
        <ul style="list-style-type:none">
            <li><a href="{{action('RozcestiController@ukolovaMzda')}}"
            class="btn btn-primary btn-lg btn-block show">Generování úkolové mzdy</a></li>
            <li class="skryte"><input type="username" name="datumUklMzda" placeholder="Datum" required></li>
        </ul>
        <ul  style="list-style-type:none">
            <li><a href="{{action('RozcestiController@odvadeciVykaz')}}"
            class="btn btn-primary btn-lg btn-block">Odváděcí výkaz</a></li>
            <li class="skryte"><input type="username" name="datumOdvVykaz" placeholder="Datum" required></li>
        </ul>
    </div>
  </div>

  @if (Auth::User()->role == 'admin')
  <div class="col-md-4 col-md-offset-4">
    <hr>
    <ul list-style-type='none'>
    <a href="{{action('HomeController@register')}}"
    class="btn btn-primary btn-lg btn-block">Registrace nového uživatele</a>
    </ul>
  </div>
  @endif
</div>


@stop
