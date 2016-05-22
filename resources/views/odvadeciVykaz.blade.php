@extends('master')

@section('title', 'Odváděcí výkaz')

@section('content')

<h1 align="center">Odváděcí výkaz</h1>

<style type="text/css">
    table{
        text-align:center;
        width:90%;
    }
    td{
        width:100px;
        height:2em;
    }
    input{
        width:100%;
        height:2em;
        text-align:center;

    }
    .firstRow{
        background-color:#6BB9F0; /*#6699CC;*/
        font-weight:bold;
    }
    .col-md-4{
        width:100%;
    }
</style>

<table border="1" align="center">

<?php
$numberofVPs  = count($VPs);
$numOfRows    = $numberofVPs + 1; //count($Objednavky);
$numOfCols = 18;

$counter=0;
for ($row = 0; $row <= $numOfRows; $row++) {
    for ($col = 0; $col < $numOfCols; $col++) {
        //zacatek radku
        if ($col == 0)
            echo "<tr>";
        //naplaneni prvniho radku
        if ($row == 0) {
            if ( $col == 0 )
                echo "<td class='firstRow' rowspan='2'>Číslo VP</td>";
            if ( $col == 1 )
              echo "<td class='firstRow' rowspan='2'>Název Akce</td>";
            if ( $col == 2 )
                echo "<td class='firstRow' colspan='3'>Počáteční stav nedokončené výroby</td>";
            if ( $col == 5 )
                echo "<td class='firstRow' colspan='2'> Náběh nákladů v běžném měsíci</td>";
            if ( $col == 7 )
                echo "<td class='firstRow' colspan='2'>Počáteční stav nedokončené výroby</td>";
            if ( $col == 7 )
                echo "<td class='firstRow' colspan='2'>Celkem náklady</td>";
            if ( $col == 9 )
                echo "<td class='firstRow' colspan='2'>Náklady na dokončené výkony</td>";
            if ( $col == 11 )
                echo "<td class='firstRow' colspan='2'>Konečný stav nedokončené výroby</td>";
            if ( $col == 13 )
                echo "<td class='firstRow' rowspan='2'>Fakturace</td>";
             if ( $col == 14 )
                echo "<td class='firstRow' colspan='3'>Rozpracovanost</td>";
        }
        if ( $row == 1){
            if ( $col == 2 )
                echo "<td class='firstRow'>Materiál</td>";
            if ( $col == 3 )
                echo "<td class='firstRow'>Polotovary vlastní výroby</td>";
            if ( $col == 4 )
                echo "<td class='firstRow'>Mzdy</td>";
            if ( $col == 5 )
                echo "<td class='firstRow'>Materiál</td>";
            if ( $col == 6 )
                echo "<td class='firstRow'>Mzdy</td>";
            if ( $col == 7 )
                echo "<td class='firstRow'>Materiál</td>";
            if ( $col == 8 )
                echo "<td class='firstRow'>Mzdy</td>";
            if ( $col == 9 )
                echo "<td class='firstRow'>Materiál</td>";
            if ( $col == 10 )
                echo "<td class='firstRow'>Mzdy</td>";
            if ( $col == 11 )
                echo "<td class='firstRow'>Materiál</td>";
            if ( $col == 12 )
                echo "<td class='firstRow'>Polotovary vlastní výroby</td>";
            if ( $col == 13 )
                echo "<td class='firstRow'>Mzdy</td>";
            if ( $col == 15 )
                echo "<td class='firstRow'>Minulý měsíc</td>";
            if ( $col == 16 )
                echo "<td class='firstRow'>Aktuální měsíc</td>";
            if ( $col == 17 )
                echo "<td class='firstRow'>Rozdíl</td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row > 1) {
            //naplneni prvniho sloupce (ID obj)
            $value=$VPs[$row-2]->ID_Obj;
            if ( !empty($value) )
                echo "<td>" . "<input type='text' name='[$row][$col]' value=$value></td>";
            else
                echo "<td></td>";
            }
        elseif ($col > 1 && $row > 1) {
            //vypis tela tabulky
            echo "<td><input></td>";
            }
        elseif ($col == 1 && $row > 1 ){
            //naplneni druheho sloupce (jmena Obj)
            $value = $VPs[$row-2]->jmeno;
            if ( !empty($value) )
                echo "<td>" . "<input type='text' name='[$row][$col]' value='$value'></td>";
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
    <div class = "col-md-4" align="center">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
    </div>
</p>
@stop
