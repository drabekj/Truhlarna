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
<?php

?>
<p>
    <div class = "col-md-4">
        <ul style="margin-left:10%">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
        </ul>
    </div>
</p>

@stop
