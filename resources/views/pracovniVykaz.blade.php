@extends('master')

@section('title', 'Pracovní výkaz')

@section('content')

<h1>Pracovní výkaz<h1>
    
<p>Pro zaměstnance: REQUESTzMinStranky(PHP) pro odbdobí REQUESTzMinStranky</p>


<table border="1" style="width:100%">
<?php
$jmeno="Dan";
$id=1;
$prijmeni="Hulka";
$numOfRows = 10;
/*dotaz na databazi - pocet radku z databaze*/

$numOfCols = 36;

for ($i=0; $i<$numOfRows;$i++){
    for($j=0;$j<$numOfCols;$j++){
        if ( $j==0 )
            echo "<tr>";
        if ($j==$numOfCols)
            echo "</tr>";
        if ( $j == 0 && $i == 0 )
            echo "<td>" . "Číslo VP" . "</td>";
        if ( $i == 0 ){
            if ( $j == 32 )
             echo "<td>" . "hodiny" . "</td>";
            elseif ( $j == 33 )
             echo "<td>" . "sazba" . "</td>";
            elseif ( $j == 34 )
             echo "<td>" . "Mzda U" . "</td>";
            elseif ( $j == 35 )
             echo "<td>" . "Mzda C" . "</td>";
            elseif ( $j != 0 )
             echo "<td>" . $j . "</td>";
        }
        if ( $j == 0 && $i != 0 )
            echo "<td>" . "a" . "</td>";
        if ( $j != 0 && $i != 0 )
            echo "<td>" . "<input type='text' size='2'>" . "</td>";
        /*podle indexu i a j vlozi na prislusne misto do databaze */
    }
}
?>

</table>

@stop