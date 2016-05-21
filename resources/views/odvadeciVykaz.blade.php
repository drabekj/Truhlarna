@extends('master')

@section('title', 'Odváděcí výkaz')

@section('content')

<h1 align="center">Odváděcí výkaz</h1>

<style type="text/css">
    table{
        text-align:center;
    }
    td{
        width:100px;
        height:2em;
    }
    input{
        /*width:100px;*/
        width:100%;
    }
</style>

<table border="1" width="80%" align="center">

<?php
$numberofVPs  = count($VPs);
$numOfRows    = $numberofVPs + 1;
$numOfCols = 18;

$counter=0;
for ($row = 0; $row <= $numOfRows; $row++) {
    for ($col = 0; $col <= $numOfCols; $col++) {
        //zacatek radku
        if ($col == 0)
            echo "<tr>";
        //naplaneni prvniho radku
        if ($row == 0) {
            if ( $col == 0 )
                echo "<td rowspan='2'>Číslo VP</td>";
            if ( $col == 1 )
              echo "<td rowspan='2'>Název Akce</td>";
            if ( $col == 2 )
                echo "<td colspan='3'>Počáteční stav nedokončené výroby</td>";
            if ( $col == 5 )
                echo "<td colspan='2'> Náběh nákladů v běžném měsíci</td>";
            if ( $col == 7 )
                echo "<td colspan='2'>Počáteční stav nedokončené výroby</td>";
            if ( $col == 7 )
                echo "<td colspan='2'>Celkem náklady</td>";
            if ( $col == 9 )
                echo "<td colspan='2'>Náklady na dokončené výkony</td>";
            if ( $col == 11 )
                echo "<td colspan='2'>Konečný stav nedokončené výroby</td>";
            if ( $col == 13 )
                echo "<td rowspan='2'>Fakturace</td>";
             if ( $col == 14 )
                echo "<td colspan='3'>Rozpracovanost</td>";
        }
        if ( $row == 1){
            if ( $col == 2 )
                echo "<td>Materiál</td>";
            if ( $col == 3 )
                echo "<td>Polotovary vlastní výroby</td>";
            if ( $col == 4 )
                echo "<td>Mzdy</td>";
            if ( $col == 5 )
                echo "<td>Materiál</td>";
            if ( $col == 6 )
                echo "<td>Mzdy</td>";
            if ( $col == 7 )
                echo "<td>Materiál</td>";
            if ( $col == 8 )
                echo "<td>Mzdy</td>";
            if ( $col == 9 )
                echo "<td>Materiál</td>";
            if ( $col == 10 )
                echo "<td>Mzdy</td>";
            if ( $col == 11 )
                echo "<td>Materiál</td>";
            if ( $col == 12 )
                echo "<td>Polotovary vlastní výroby</td>";
            if ( $col == 13 )
                echo "<td>Mzdy</td>";
            if ( $col == 15 )
                echo "<td>Minulý měsíc</td>";
            if ( $col == 16 )
                echo "<td>Aktuální měsíc</td>";
            if ( $col == 17 )
                echo "<td>Rozdíl</td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row > 1) {
            $value=$Objednavky[$i]->ID_Obj->ID_Obj; //$VPs[$row-2]->Id_Obj;
            if ( !empty($value) )
                echo "<td>" . "<input type='text' name='[$row][$col]' value=$value></td>";
            else
                echo "<td></td>";
            }
        elseif ($col == 1 && $row > 1) {
            //forem vypsat jednotlive nazvy akci (asi jen jmeno k vp) do slopecku
            }
        elseif ($col > 1 && $row > 1 ){
            //nejakej dotazt do DB - podle struktury ulozeni v DB
            $value = $Objednavky[$i]->jmeno_Obj; //$VPs[$row-2]->jmeno_Obj;
            if ( !empty($value) )
                echo "<td>" . "<input type='text' name='[$row][$col]' value=$value></td>";
            else
                echo "<td></td>";
        }
        //konec radku
       if ($col == $numOfCols)
            echo "</tr>";
    }
}
?>
</table>




<p>
    <div class = "col-md-4">
        <ul style="margin-left:10%">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
        </ul>
    </div>
</p>

@stop
