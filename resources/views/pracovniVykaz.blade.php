@extends('master')

@section('title', 'Pracovní výkaz')

@section('content')
<h1 align="center">Pracovní výkaz</h1>
<p align="center">Zaměstnanec: {{ $Truhlar->jmeno }} {{ $Truhlar->prijmeni }} Odbdobí: {{ $Datum->rok }}-{{ $Datum->mesic }}  </p>

<style type="text/css">
    td{
        text-align: center;
    }

    table{
        border-spacing: 0;
        border-collapse: separate;
    }

    #space{
        padding:2em;
    }
</style>

<form class="form-horizontal" role="form" method="POST" action="{{ url('pracovniVykaz/store') }}">
{{-- <form class="form-horizontal" role="form" method="POST" action="{{ url('/test') }}"> --}}
  {!! csrf_field() !!}
<table border="1" width="80%" align="center">

<?php
/* __ PRVNI TABULKA __*/
echo "<input hidden name='truhlar_id' value='" . $Truhlar->id . "'>";
echo "<input hidden name='rok' value='" . $Datum->rok . "'>";
echo "<input hidden name='mesic' value='" . $Datum->mesic . "'>";

$numOfRows = $numOfRowsT1;
$counter=0;
for ($row = 0; $row <= $numOfRows-2; $row++) {
    for ($col = 0; $col < $numOfCols; $col++) {
        //zacatek radku
        if ($col == 0)
            echo "<tr>";
        //konec radku
       if ($col == $numOfCols)
            echo "</tr>";
        // bunka [0,0]
        if ($col == 0 && $row == 0)
            echo "<td>" . "Číslo VP" . "</td>";
        //naplaneni prvniho radku
        if ($row == 0) {
            if ($col == $numOfCols-3)
               echo "<td>" . "sazba" . "</td>";
            elseif ($col == $numOfCols-4)
                echo "<td>" . "Hodiny" . "</td>";
            elseif ($col == $numOfCols-2)
                echo "<td>" . "Mzda U" . "</td>";
            elseif ($col == $numOfCols-1)
                echo "<td>" . "Mzda C" . "</td>";
            elseif ($col != 0)
                echo "<td><b>" . $col . "</b></td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row != 0) {
            //cislo VP
            if ($row < $VPs->count() + 1)
                echo "<td><input name='$row.$col' value='" . $VPs[$row - 1]->ID_Obj . "'></td>";
            else {
                //jinak vypise policko pro vlozeni hodnoty
                echo "<td size='8'><input type='text' name='$row.$col'>" . "</td>";
            }
        //naplneni hodnot do tabulky
        } elseif ($col != 0 && $row != 0) {
            $value="";
            if ($row < $VPs->count() + 1){
              if(count($queryData[$row][$col])!=0)
                $value=$queryData[$row][$col][0]->Hodiny;
            }
            //hodiny z databaze
            echo "<td>" . "<input type='text' size='4' name='$row.$col' value=$value></td>";
            $counter++;
        }
    }
}
?>
</table>

<!-- NEMAZAT! -->
<div id="space"></div>

<table border="1" width="80%" align="center">

<?php
/* __ DRUHA TABULKA __*/
$counter=0;
$numOfRows = $numOfRowsT2;
for ($row = 0; $row < $numOfRows; $row++) {
    for ($col = 0; $col < $numOfCols; $col++) {
        //zacatek radku
        if ($col == 0)
            echo "<tr>";
        //konec radku
       if ($col == $numOfCols)
            echo "</tr>";
        //naplaneni prvniho radku
        if ($row == 0) {
            if ( $col == 0 || $col > $Datum->numOfDays )
                echo "<td></td>";
            else
                echo "<td><b>" . $col . "</b></td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row != 0) {
            //vypise cislo VP
            if ($row == 1)
                echo "<td>Odp dny</td>";
            if ($row == 2)
                echo "<td>Dovolena</td>";
            if ($row == 3)
                echo "<td>Nemoc</td>";
            if ($row == 4)
                echo "<td>Svátek</td>";
            if ($row == 5)
                echo "<td>Celkem dny</td>";
            if ($row == 6)
                echo "<td>Celkem hod</td>";
            if ($row == 7)
                echo "<td>Přesčas</td>";
        }
        elseif($col > 0 && $col<$Datum->numOfDays+2 && $row > 0){
            //dotaz do DB pro poc hod - nemoc, dovolena atd.

            // row - Odpracovane dny
            if ( $row == 1 ){
              $value = $odpracovaneDny[$col];
              echo "<td>" . $value . "</td>";
            }
            // row - Dovolena
            if ( $row == 2 ){
              $value = $dovolena[$col];
              echo "<td><input type='text' size='8' name='t2[$row][$col]' value=$value></td>";

              if ( $col == $Datum->numOfDays+1 ){
                echo "<td colspan='2'>Cestovné:</td>";
                echo "<td>" . "<input type='text' size='8' name='[$row][$col+1]'></td>";
              }
            }
            // row - Nemoc
            if ( $row == 3 ){
              $value = $nemoc[$col];
              echo "<td><input type='text' size='8' name='t2[$row][$col]' value=$value></td>";

              if ( $col == $Datum->numOfDays+1 ){
                echo "<td colspan='2'>Stravenky:</td>";
                echo "<td>" . "<input type='text' size='8' name='[$row][$col+1]'></td>";
              }
            }
            // row - Svatek
            if ( $row == 4 ){
              $value = $svatek[$col];
              echo "<td><input type='text' size='8' name='t2[$row][$col]' value=$value></td>";

              if ( $col == $Datum->numOfDays+1 ){
                echo "<td colspan='2'>Obědy:</td>";
                echo "<td>" . "<input type='text' size='8' name='[$row][$col]'></td>";
              }
            }
            if ( $row == 5 ){
              if ($celkemAbsenceHodiny[$col])
                echo "<td>" . $celkemAbsenceHodiny[$col] . "</td>";
              else
                echo "<td></td>";
            }
            if ( $row == 6 ){
              if ($celkemAbsenceHodiny[$col])
                echo "<td>" . $celkemAbsenceHodiny[$col]*8 . "</td>";
              else
                echo "<td></td>";
            }
            if ( $row == 7 ){
              echo "<td></td>";
            }


            // else{
            //     if ( ($row == 1 || $row == 2 || $row == 6 || $row == 7) && ($col > $Datum->numOfDays+2) )
            //         echo "<td></td>";
            //     else{
            //     $value = 0;
            //         echo "<td>" . "<input type='text' size='4' name='[$row][$col]' value=$value></td>";
            //     }
            // }
        }

    }
}
?>
</table>

<p>
    <div class = "col-md-4">
        <a href="{{action('RozcestiController@rozcesti')}}"
            button type="button" class="btn btn-primary btn-lg">Zpět</a>

        <button type="submit" class="btn btn-primary btn-lg" value="Potvrdit">
          Uložit
        </button>
    </div>
</p>
</form>

<hr>

@stop
