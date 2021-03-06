@extends('master')

@section('title', 'Pracovní výkaz')

@section('content')
<h1 align="center">Pracovní výkaz</h1>
<p align="center"><b>Zaměstnanec:</b>  {{ $Truhlar->jmeno }} {{ $Truhlar->prijmeni }} (id:{{$Truhlar->id}}) <b>Odbdobí:</b> 1.{{ $Datum->mesic }}.{{ $Datum->rok }}-{{ $Datum->numOfDays }}.{{ $Datum->mesic }}.{{ $Datum->rok }}  </p>

<style type="text/css">
    table{
        text-align: center;
        width:85%;
    }

    input{
        width:100%;
        height:2em;
        text-align:center;
    }

    td{
        height:2em;
        z-index: initial;
    }
    tr{
        z-index: 10;
    }
    .text{
        width:5%;
        height:2em;
    }

    .textLonger{
        /*width has to 2times more than in .text*/
        width:10%;
        background-color:#eeeeee;
    }

    .firstRow{
        font-weight: bold;
        height:3em;
        background-color:#6BB9F0; /*#6699CC;*/
    }

    .colorfull{
         background-color:#eeeeee;
    }

    .colorfull_VPs{
         background-color:#F0F8FF;
    }

    .colorfull_T2_left{
         background-color:#6BB9F0;
    }

    .color_result{
         background-color:#FDE3A7;
    }

    #space{
        padding:2em;
    }

    #hod{
        z-index: -1;
        left:5.5%;
        width:2%;
        position:absolute;
        border:2px solid black;
        height:6em;
    }

    #narrowDiv{
        width: 0;
        word-wrap: break-word;
        font-weight:bold;
        padding: 25% 33%;
    }

    .col-md-4{
        width:100%;
        align:center;
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
for ($row = 0; $row <= $numOfRows+1; $row++) {
    for ($col = 0; $col < $numOfCols; $col++) {
        //zacatek radku
        if ($col == 0)
            echo "<tr>";
        //konec radku
       if ($col == $numOfCols)
            echo "</tr>";
        // bunka [0,0]
        if ($col == 0 && $row == 0)
            echo "<td class='text firstRow'>" . "Číslo VP" . "</td>";
        //naplaneni prvniho radku
        if ($row == 0) {
            if ($col == $numOfCols-3)
               echo "<td class='text firstRow'>" . "sazba" . "</td>";
            elseif ($col == $numOfCols-4)
                echo "<td class='text firstRow'>" . "Hodiny" . "</td>";
            elseif ($col == $numOfCols-2)
                echo "<td class='text firstRow'>" . "Mzda U" . "</td>";
            elseif ($col == $numOfCols-1)
                echo "<td class='text firstRow'>" . "Mzda C" . "</td>";
            elseif ($col != 0)
                echo "<td class='firstRow'>" . $col . "</td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row != 0) {
            //cislo VP
            if ($row < $VPs->count() + 1)
                echo "<td><input name='$row.$col' value='" . $VPs[$row - 1]->ID_Obj . "' class='colorfull_VPs'></td>";
            else if ($row < 12){
                //jinak vypise policko pro vlozeni hodnoty
                echo "<td><input type='text' name='$row.$col' class='colorfull_VPs'>" . "</td>";
            }
            else if ( $row == 12)
                echo "<td class='colorfull'>C.hod.úkol</td>";
            else if ( $row == 13)
                echo "<td class='colorfull'>Režie</td>";
            else if ( $row == 14)
                echo "<td class='colorfull'>Celkem</td>";

        //naplneni hodnot do tabulky
      } elseif ($col != 0 && $row != 0) {
            $value="";
            // vyplneni odpracovanych hodin ke dnum v mecici pro VP
            if ($row < $VPs->count() + 1 && $col<=$Datum->numOfDays){
              if(count($queryData[$row][$col])!=0)
                $value=$queryData[$row][$col][0]->Hodiny;
            }
            if ( $row == 14 && $col < 32 ){
              if($col <= count($celkemJednotliveDny))
                $value = $celkemJednotliveDny[$col];
            }
            // naplneni hodnot souctu na prave strane tabulky
            else{
              if ( $col == $Datum->numOfDays+1 )
                $value = $pravyPanelData[$Datum->numOfDays+1][$row];
              if ( $col == $Datum->numOfDays+2 )
                $value = $pravyPanelData[$Datum->numOfDays+2][$row];
              if ( $col == $Datum->numOfDays+3 )
                $value = $pravyPanelData[$Datum->numOfDays+3][$row];
            }
            //hodiny z databaze
            if ( $row == 14 && $col >= $Datum->numOfDays+3)
              echo "<td class='color_result'>" . $value . "</td>";
            else if ( $row > 11 || $col > $Datum->numOfDays )
              echo "<td class='colorfull'>" . $value . "</td>";
            else
              echo "<td>" . "<input type='text' name='$row.$col' value=$value></td>";
            $counter++;
        }
    }
}
?>
</table>

<div id="space"></div>

<table align="center" border='1'>
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
            if ( $col == 0 )
                echo "<td class='text'></td>";
            elseif ( $col > $Datum->numOfDays )
               echo "";//"<td class='text2'></td>";
            else
                echo "<td class='firstRow'>" . $col . "</td>";
        }
        //vypsani sloupecku cisel VP
        if ($col == 0 && $row != 0) {
            //vypise cislo VP
            if ($row == 1)
                echo "<td class='colorfull_T2_left'>Odp dny</td>";
            if ($row == 2)
                echo "<td class='colorfull_T2_left'>Dovolena</td>";
            if ($row == 3)
                echo "<td class='colorfull_T2_left'>Nemoc</td>";
            if ($row == 4)
                echo "<td class='colorfull_T2_left'>Svátek</td>";
            if ($row == 5)
                echo "<td class='colorfull_T2_left'>Celkem dny</td>";
            if ($row == 6)
                echo "<td class='colorfull_T2_left'>Celkem hod</td>";
            if ($row == 7)
                echo "<td class='colorfull_T2_left'>Přesčas</td>";
        }
        elseif($col > 0 && $col<$Datum->numOfDays+2 && $row > 0){
            //dotaz do DB pro poc hod - nemoc, dovolena atd.

            // row - Odpracovane dny
            if ( $row == 1 ){
              $value = $odpracovaneDny[$col];
              echo "<td class='colorfull'>" . $value . "</td>";
            }
            //row - Dovolena
            if ( $row == 2 ){
              $value = $dovolena[$col];
              if ( $col>=32 )
                echo "<td class='text'><input type='text' name='t2[$row][$col]' value=$value></td>";
              else{
                if ($col == 1)
                   echo "<td><div id='hod'><div id='narrowDiv'>HOD</div></div>
                   <input type='text' name='t2[$row][$col]' value=$value></td>";
                else
                    echo "<td><input type='text' name='t2[$row][$col]' value=$value></td>";
              }

              if ( $col == $Datum->numOfDays+1 ){
                echo "<td class='textLonger' colspan='2'>Cestovné:</td>";
                echo "<td class='text'>" . "<input type='text' name='t2[$row][$col+1]' class='color_result'></td>";
              }
            }
            // row - Nemoc
            if ( $row == 3 ){
              $value = $nemoc[$col];
              echo "<td><input type='text' name='t2[$row][$col]' value=$value></td>";

              if ( $col == $Datum->numOfDays+1 ){
                echo "<td class='textLonger' colspan='2'>Stravenky:</td>";
                echo "<td>" . "<input type='text' name='t2[$row][$col+1]' class='color_result'></td>";
              }
            }
            // row - Svatek
            if ( $row == 4 ){
              $value = $svatek[$col];
              echo "<td><input type='text' name='t2[$row][$col]' value=$value></td>";

              if ( $col == $Datum->numOfDays+1 ){
                echo "<td class='textLonger' colspan='2'>Obědy:</td>";
                echo "<td>" . "<input type='text' name='t2[$row][$col]' class='color_result'></td>";
              }
            }
            if ( $row == 5 ){
              if ($celkemAbsenceHodiny[$col])
                echo "<td class='colorfull'>" . $celkemAbsenceHodiny[$col] / 8 . "</td>";
              else
                echo "<td class='colorfull'>0</td>";
            }
            if ( $row == 6 ){
              if ($celkemAbsenceHodiny[$col])
                echo "<td class='colorfull'>" . $celkemAbsenceHodiny[$col] . "</td>";
              else
                echo "<td class='colorfull'>0</td>";
            }
            if ( $row == 7 ){
              echo "<td class='colorfull'></td>";
            }
        }

    }
}
?>
</table>

<div id="space" clear="both"></div>
<div>
<div class="col-md-4" align="center">
    <a href="{{action('RozcestiController@rozcesti')}}"
        button type="button" class="btn btn-primary btn-lg">Zpět</a>

    <button type="submit" class="btn btn-primary btn-lg" value="Potvrdit">Uložit</button>
</div>
</div>
</form>

<hr>



@stop
