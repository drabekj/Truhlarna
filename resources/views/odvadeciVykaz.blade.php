@extends('master')

@section('title', 'Odváděcí výkaz')

@section('loggedAs')
<?php 
$accountType = "Karel (admin)";
echo "<p class='navbar-brand' float='right'>Přihlášen jako: " . $accountType;
?>
</p>
@stop

@section('content')

<h1 align="center">Odváděcí výkaz</h1>


@stop