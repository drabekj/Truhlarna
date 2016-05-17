@extends('master')

@section('title', 'Rozcestí')

@section('loggedAs')
<?php 
$accountType = "admin";
echo "<p class='navbar-brand' float='right'>Přihlášen jako: " . $accountType;
?>
</p>
@stop

@section('content')
<p id="accountType">

<button type="button" onclick="alert('Hello world!')">Vyplnění pracovního výkazu</button>
<button type="button" onclick="alert('Hello world!')">Generování úkolové mzdy</button>
<button type="button" onclick="alert('Hello world!')">Odváděcí výkaz</button>

<input type="username" name="username" placeholder="Uživatelské jméno" required>
<input type="username" name="username" placeholder="Uživatelské jméno" required>

@stop