@extends('master')

@section('title', 'Pracovní výkaz')

@section('content')
<?php
$jmenoTruhlare= DB::table("Zamestnanec")->select("Jmeno", "Prijmeni")
->where("ID_Zam", "=", $vykaz_data->username)
->get();
?>
<h1 align="center">Pracovní výkaz</h1>
<p align="center">Zaměstnanec: {{ $jmenoTruhlare[0]->Jmeno }} {{ $jmenoTruhlare[0]->Prijmeni }} Odbdobí: {{ $vykaz_data->datumPracvykaz }} </p>

<style type="text/css">
    td{
        text-align: center;
    }
    
    table{
        border-spacing: 0;
        border-collapse: separate;
    }
</style>

<table border="1" width="80%" align="center">

<?php
/*dotaz na databazi - pocet radku z databaze*/

$numOfCols    = 36;
$TruhlarID    = $vykaz_data->username ;
$mesic        = date("m",strtotime($vykaz_data->datumPracvykaz));
$rok          = date("Y",strtotime($vykaz_data->datumPracvykaz));


$VPs = DB::table("Pracovni_den")->select("Cislo_VP")
->where("Pracovni_den.ID_Zam", "=", $TruhlarID)
->join('Zamestnanec', 'Zamestnanec.ID_Zam', '=', 'Pracovni_den.ID_Zam')
->whereRaw('extract(month from Datum) = ?', [$mesic])
->whereRaw('extract(year from Datum) = ?', [$rok])
->orderBy('cislo_VP', 'asc')->distinct()->get();

$numberofVPs  = count($VPs);
$numOfRows    = $numberofVPs + 2;

$counter=0;

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
                echo "<td>" . "Hod" . "</td>";
            elseif ($j == 33)
                echo "<td>" . "sazba" . "</td>";
            elseif ($j == 34)
                echo "<td>" . "Mzda U" . "</td>";
            elseif ($j == 35)
                echo "<td>" . "Mzda C" . "</td>";
            elseif ($j != 0)
                echo "<td><b>" . $j . "</b></td>";
        }
        //vypsani sloupecku cisel VP
        if ($j == 0 && $i != 0) {
            //vypise cislo VP
            if ($i < $numberofVPs + 1)
                echo "<td>" . $VPs[$i - 1]->Cislo_VP . "</td>";
            else {
                //jinak vypise policko pro vlozeni hodnoty
                echo "<td size='8'>" . "<input type='text'>" . "</td>";
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
->get();
          if(count($day)!=0) 
  $value=$day[0]->Hodiny;}
            echo "<td>" . "<input type='text' size='4' name='bla' value=$value></td>";
            $counter++;
        }
    }
}
?>
</table>
<p>
    <input type="submit" value="Potvrdit" name="Potvrdit" onclick="insert()">
</p>



<h1>Request data: {{ $vykaz_data->username }} {{ $vykaz_data->datumPracvykaz }}</h1>

@stop