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
</style>

<form class="form-horizontal" role="form" method="POST" action="{{ url('pracovniVykaz/store') }}">
  {!! csrf_field() !!}
<table border="1" width="80%" align="center">

<?php
/*dotaz na databazi - pocet radku z databaze*/
$numberofVPs  = count($VPs);
$numOfRows    = $numberofVPs + 2;

$counter=0;
for ($row = 0; $row <= $numOfRows; $row++) {
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
            if ($col == 32)
                echo "<td>" . "Hod" . "</td>";
            elseif ($col == 33)
                echo "<td>" . "sazba" . "</td>";
            elseif ($col == 34)
                echo "<td>" . "Mzda U" . "</td>";
            elseif ($col == 35)
                echo "<td>" . "Mzda C" . "</td>";
            elseif ($col != 0)
                echo "<td><b>" . $col . "</b></td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row != 0) {
            //vypise cislo VP
            if ($row < $numberofVPs + 1)
                echo "<td><input name='[$row][$col]' value='" . $VPs[$row - 1]->Cislo_VP . "'></td>";
            else {
                //jinak vypise policko pro vlozeni hodnoty
                echo "<td size='8'><input type='text' name='[$row][$col]'>" . "</td>";
            }
        //naplneni hodnot do tabulky
        } elseif ($col != 0 && $row != 0) {
            //SQL dotaz do databaze
            $value="";
            if ($row < $numberofVPs + 1){
              if(count($queryData[$row][$col])!=0)
                $value=$queryData[$row][$col][0]->Hodiny;
            }
            echo "<td>" . "<input type='text' size='4' name='[$row][$col]' value=$value></td>";
            $counter++;
        }
    }
}
?>
</table>
<button type="submit" class="btn btn-primary btn-lg" value="Potvrdit" name="Potvrdit">
  Uložit
</button>
</form>


<hr>



@stop
