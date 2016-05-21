@extends('master')

@section('js')

<script src='http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js'></script>
<script src="lib/js/ui-grid/3.0.7/ui-grid.js"></script>

@stop

@section('title', 'Generování úkolové mzdy')

@section('content')

<h1 align="center">Generování úkolové mzdy</h1>

<style type="text/css">
    th, td{
       width:100px;
       text-align:center;
    }
    th{
        font-size:1.5em;
    }
    table{
        text-align:center;
    }
</style>

<table  border="1" align="center">
    <tr>
        <th>PP</th>
        <th></th>
        <th>Os.čís</th>
        <th></th>
        <th>Přijmení</th>
        <th></th>
        <th>Jméno</th>
        <th></th>
        <th>Hodiny</th>
        <th></th>
        <th></th>
        <th>Částka</th>
    </tr>
    
<?php
 for($i=0; $i<count($Objednavky);$i++){
     echo "<tr><td>Zakázka</td><td></td><td colspan='2'>" . $Objednavky[$i]->ID_Obj->ID_Obj . " " . $Objednavky[$i]->jmeno_Obj . "</td><td colspan='8'></td></tr>";
     $cena=0;
    for($j=0; $j<count($Objednavky[$i]->truhlari);$j++){
        echo "<tr>";
        //pricitani celkove ceny
        $cena=$cena +  $Objednavky[$i]->truhlari[$j]->pocetHodin*$Objednavky[$i]->truhlari[$j]->sazba;
        echo "<td></td><td></td><td>" . $Objednavky[$i]->truhlari[$j]->ID_Zam . "</td>" .
        "<td></td><td>" . $Objednavky[$i]->truhlari[$j]->Prijmeni . "</td>" . 
        "<td></td><td>" . $Objednavky[$i]->truhlari[$j]->Jmeno . "</td>" . 
        "<td></td><td>" . $Objednavky[$i]->truhlari[$j]->pocetHodin . "</td>" . 
        "<td></td><td></td><td>" . $Objednavky[$i]->truhlari[$j]->pocetHodin * $Objednavky[$i]->truhlari[$j]->sazba . "</td>";
        echo "</tr>";
    }
    //celkem na zakazku
    echo "<tr><td colspan='2'>Celkem za zakázku</td><td colspan='3'></td><td>" . $Objednavky[$i]->ID_Obj->ID_Obj . "</td><td colspan='2'></td><td>" .
    $Objednavky[$i]->celkoveHodin . "</td>" . "<td colspan='2'></td><td>" . $cena . "</td></tr>";
    //oddeleni jednotlivych tabulek
    echo "<tr><td colspan='12' height='5'></td></tr>";
}
?>

</table>

<div ng-controller="customersCtrl">
  <table>
   <tr ng-repeat="x in names">
     <td><% x.Name %></td>
     <td><% x.Country %></td>
   </tr>
  </table>
</div>

<p>
    <div class = "col-md-4">
        <ul style="margin-left:10%">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
        </ul>
    </div>
</p>

@stop