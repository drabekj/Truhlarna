@extends('master')

@section('title', 'Pracovní výkaz')

@section('content')

<h1 align="center">Pracovní výkaz</h1>
<p align="center">Pro zaměstnance: REQUESTzMinStranky(PHP) pro odbdobí REQUESTzMinStranky</p>


<table border="1" width="50%" align="center">

<?php
/*dotaz na databazi - pocet radku z databaze*/

$numOfCols    = 36;
$numOfRows    = 10;
$TruhlarID    = 1;
$mesic        = 1;
$rok          = 2015;

$VPs = DB::table("Pracovni_den")->select("Cislo_VP")
->where("Pracovni_den.ID_Zam", "=", $TruhlarID)
->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
->whereRaw('extract(month from Datum) = ?', [$mesic])
->orderBy('cislo_VP', 'asc')->distinct()->get();
/* 
$entries = DB::table("Pracovni_den")
->where("Pracovni_den.ID_Zam", "=", $TruhlarID)
->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
->whereRaw('extract(month from Datum) = ?', [$mesic])
->whereRaw('extract(year from Datum) = ?', [$rok])
->orderBy('Datum', 'asc')->orderBy('cislo_VP', 'asc')->get(); */
$numberofVPs  = count($VPs);
$numOfRows    = $numberofVPs + 2;
$id           = 0;
// $entryCounter = count($entries) - 1;

$numOfRows = 3;

for ($i = 0; $i <= $numOfRows; $i++) {
    for ($j = 0; $j < $numOfCols; $j++) {
        //zacatek radku
        if ($j == 0)
            echo "<tr>";
        //konec radku
       if ($j == $numOfCols)
            echo "</tr>";
        // bunka [0,0]
        if ($j == 0 && $i == 0)
            echo "<td>" . "Číslo VP" . "</td>";
        //naplaneni prvniho radku
        if ($i == 0) {
            if ($j == 32)
                echo "<td align='center'>" . "hodiny" . "</td>";
            elseif ($j == 33)
                echo "<td align='center'>" . "sazba" . "</td>";
            elseif ($j == 34)
                echo "<td align='center'>" . "Mzda U" . "</td>";
            elseif ($j == 35)
                echo "<td align='center'>" . "Mzda C" . "</td>";
            elseif ($j != 0)
                echo "<td align='center'><b>" . $j . "</b></td>";
        }
        //vypsani sloupecku cisel VP
        if ($j == 0 && $i != 0) {
            //vypise cislo VP
            if ($i < $numberofVPs + 1)
                echo "<td>" . $VPs[$i - 1]->Cislo_VP . "</td>";
            else {
                //jinak vypise policko pro vlozeni hodnoty
                echo "<td>" . "<input type='text'>" . "</td>";
            }
        //naplneni hodnot do tabulky
        } elseif ($j != 0 && $i != 0) {
            //SQL dotaz do databaze
            $value="";
             if ($i < $numberofVPs + 1){
            $day=DB::table("Pracovni_den")
->select('Pracovni_den.Hodiny')
->where("Pracovni_den.ID_Zam", "=", $TruhlarID)
->where("Cislo_VP", "=", $VPs[$i - 1]->Cislo_VP)
->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
->whereRaw('extract(month from Datum) = ?', [$mesic])
->whereRaw('extract(year from Datum) = ?', [$rok])
->whereRaw('extract(day from Datum) = ?', [$j])
->orderBy('Datum', 'asc')->orderBy('cislo_VP', 'asc')->get();
          if(count($day)!=0) 
  $value=$day[0]->Hodiny;}
            echo "<td>" . "<input type='text' size='3' value=$value></td>";
        }
    }
}
function insert(){
    echo "kugfdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddnd";
}
?>
</table>
<p>
    <input type="submit" value="Potvrdit" name="Potvrdit" onclick="insert()">
</p>

@stop