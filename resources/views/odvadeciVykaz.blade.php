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
        /*width:100px;*/
        width:100%;
    }
    .firstRow{
        background-color:#6BB9F0; /*#6699CC;*/
    }
    .col-md-4{
        width:100%;
    }
</style>

<div id="pdf_content">
<table border="1" align="center">

<?php
$numberofVPs  = count($VPs);
$numOfRows    = $numberofVPs + 1; //count($Objednavky);
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
                echo "<td class='firstRow'>Číslo VP</td>";
            if ( $col == 1 )
              echo "<td class='firstRow'>Název Akce</td>";
            if ( $col == 2 )
                echo "<td class='firstRow'>Počáteční stav nedokončené výroby</td>";
            if ( $col == 5 )
                echo "<td class='firstRow'> Náběh nákladů v běžném měsíci</td>";
            if ( $col == 7 )
                echo "<td class='firstRow'>Počáteční stav nedokončené výroby</td>";
            if ( $col == 7 )
                echo "<td class='firstRow'>Celkem náklady</td>";
            if ( $col == 9 )
                echo "<td class='firstRow'>Náklady na dokončené výkony</td>";
            if ( $col == 11 )
                echo "<td class='firstRow'>Konečný stav nedokončené výroby</td>";
            if ( $col == 13 )
                echo "<td class='firstRow'>Fakturace</td>";
             if ( $col == 14 )
                echo "<td class='firstRow'>Rozpracovanost</td>";
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
            $value=$VPs[$row-2]->Id_Obj; //$Objednavky[$i]->ID_Obj->ID_Obj;
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
            $value = $VPs[$row-2]->jmeno_Obj; //$Objednavky[$i]->jmeno_Obj;
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
</div>



<p>
    <div class = "col-md-4" align="center">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
    </div>
</p>

<script type="text/javascript" >

  function genPDF(){
    var pdf = new jsPDF('l', 'mm', [450, 410]);

    source = $('#pdf_content')[0];
    specialElementHandlers = {
        '#bypassme': function (element, renderer) {
           return true
        }
    };

    margins = {
      top: 80,
      bottom: 60,
      left: 10,
      width: 700
    };

    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },
    function (dispose) {
      // dispose: object with X, Y of the last line add to the PDF
      //          this allow the insertion of new lines after html
      pdf.save('odvadeci_vykaz.pdf');
    }, margins);
  }

</script>
  <button onclick="genPDF()" class="button">Run Code</button>
@stop
