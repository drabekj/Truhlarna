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
        background-color:#6BB9F0; /*#6699CC;*/
    }
    table{
        text-align:center;
        width:80%;
    }
    input{
        text-align:center;
    }
    .col-md-4{
        width:100%;
    }
</style>

<div id="pdf_content">
<table border="1" align="center">
    <tr>
        <th>PP</th>
        <th></th>
        <th>Os.cis</th>
        <th></th>
        <th>Prijmeni</th>
        <th></th>
        <th>Jmeno</th>
        <th></th>
        <th>Hodiny</th>
        <th></th>
        <th></th>
        <th>Castka</th>
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
    echo "<tr><td colspan='2'>Celkem za zakazku</td><td colspan='3'></td><td>" . $Objednavky[$i]->ID_Obj->ID_Obj . "</td><td colspan='2'></td><td>" .
    $Objednavky[$i]->celkoveHodin . "</td>" . "<td colspan='2'></td><td>" . $cena . "</td></tr>";
    //oddeleni jednotlivych tabulek
    echo "<tr><td colspan='12' height='5'></td></tr>";
}
?>

</table>
</div>

<div ng-controller="customersCtrl">
  <table>
   <tr ng-repeat="x in names">
     <td><% x.Name %></td>
     <td><% x.Country %></td>
   </tr>
  </table>
</div>

<p>
    <div class = "col-md-4" align="center">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
            <button onclick="genPDF()"
            class="btn btn-primary btn-lg">Uložit PDF</button>
    </div>
</p>

<div heigth='3em'>AAA</div>

<script type="text/javascript" >

  function genPDF(){
    var pdf = new jsPDF('p', 'mm', [550, 650]);

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
      pdf.save('ukolova_mzda.pdf');
    }, margins);
  }

</script>

@stop
