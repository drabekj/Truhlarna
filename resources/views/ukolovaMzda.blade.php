@extends('master')

@section('title', 'Generování úkolové mzdy')

@section('loggedAs')
<?php
$accountType = "Karel (admin)";
echo "<p class='navbar-brand' float='right'>Přihlášen jako: " . $accountType;
?>
</p>
@stop

@section('content')

<h1 align="center">Generovani ukolove mzdy</h1>


@stop
