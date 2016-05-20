@extends('master')

@section('js', "<script src='http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js'></script>")

@section('title', 'Generování úkolové mzdy')

@section('content')

<h1 align="center">Generovani ukolove mzdy</h1>



 <?php
 
 // vyipse cislo obj jmeno obj
    // id a jmeno truhlare, pocet hodin na ty objednavce
// celkovy pocet hodin na objednavce
//-----
//dalsi objednavka
// pocet provsechny objednavky ziskas jednoduse forem
// chybi mi tam cena celkova, bud doplnim zitra a nebo to taky jenom projet forem, je to tu vsechno naznaceny
 
 for($i=0; $i<count($Objednavky);$i++){
     echo $Objednavky[$i]->ID_Obj. " " . $Objednavky[$i]->jmeno_Obj . '<br>';
     $cena=0;
    for($j=0; $j<count($Objednavky[$i]->truhlari);$j++){
        $cena=$cena +  $Objednavky[$i]->truhlari[$j]->pocetHodin*$Objednavky[$i]->truhlari[$j]->sazba;
        echo $Objednavky[$i]->truhlari[$j]->ID_Zam . " " .
        $Objednavky[$i]->truhlari[$j]->Jmeno . " " . 
        $Objednavky[$i]->truhlari[$j]->Prijmeni . " ". 
        $Objednavky[$i]->truhlari[$j]->pocetHodin . " " . 
        $Objednavky[$i]->truhlari[$j]->pocetHodin*$Objednavky[$i]->truhlari[$j]->sazba . " " .
        '<br>'; 

    }
    echo $Objednavky[$i]->celkoveHodin . 
        $cena . '<br>';
     
 }
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
