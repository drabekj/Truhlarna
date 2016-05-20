@extends('master')

@section('js')

<script src='http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js'></script>
<script src="lib/js/ui-grid/3.0.7/ui-grid.js"></script>

@stop

@section('title', 'Generování úkolové mzdy')

@section('content')

<h1 align="center">Generovani ukolove mzdy</h1>



<div ng-app="myApp" ng-controller="customersCtrl"> 
<table>
  <tr ng-repeat="x in names">
    <td>{{ x.Name }}</td>
    <td>{{ x.Country }}</td>
  </tr>
</table>

</div>

<script>
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http) {
    $http.get("http://www.w3schools.com/angular/customers.php")
    .then(function (response) {$scope.names = response.data.records;});
});
</script>

<!--

<div ng-app="myApp" ng-controller="customersCtrl"> 

<table>

  <tr ng-repeat="data in obj track by $index">
    <td>{{ x.Name }}</td>    <td>{{ x.Country }}</td>    <td>{{ x.Cislo_VP }}</td>    <td>{{ x.ID_Zam }}</td>    <td>{{ x.Prijmeni }}</td>    <td>{{ x.meno }}</td> 
    <td>{{ data.pocetHodin }}</td>
    <td>{{ data.Sazba }}</td>
  </tr>
  
</table>

</div>


<script type="text/javascript">
//var angular;
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http) {
    $http.get("http://truhla-truhla.c9users.io/ukolovaMzda")
    .then(function (response) {
        $scope.obj = response;
    });
});

</script>

-->



 <?php
 
 // vyipse cislo obj jmeno obj
    // id a jmeno truhlare, pocet hodin na ty objednavce
// celkovy pocet hodin na objednavce
//-----
//dalsi objednavka
// pocet provsechny objednavky ziskas jednoduse forem
// chybi mi tam cena celkova, bud doplnim zitra a nebo to taky jenom projet forem, je to tu vsechno naznaceny
 
 for($i=0; $i<count($Objednavky);$i++){
     echo $Objednavky[$i]->ID_Obj. " " . $Objednavky[$i]->jmeno_Obj . '<br>';
     $cena=0;
    for($j=0; $j<count($Objednavky[$i]->truhlari);$j++){
        $cena=$cena +  $Objednavky[$i]->truhlari[$j]->pocetHodin*$Objednavky[$i]->truhlari[$j]->sazba;
        echo $Objednavky[$i]->truhlari[$j]->ID_Zam . " " .
        $Objednavky[$i]->truhlari[$j]->Jmeno . " " . 
        $Objednavky[$i]->truhlari[$j]->Prijmeni . " ". 
        $Objednavky[$i]->truhlari[$j]->pocetHodin . " " . 
        $Objednavky[$i]->truhlari[$j]->pocetHodin*$Objednavky[$i]->truhlari[$j]->sazba . " " .
        '<br>'; 

    }
    echo $Objednavky[$i]->celkoveHodin . 
        $cena . '<br>';
     
 }
 ?>

<p>
    <div class = "col-md-4">
        <ul style="margin-left:10%">
            <a href="{{action('RozcestiController@rozcesti')}}"
            class="btn btn-primary btn-lg">Zpět</a>
        </ul>
    </div>
</p>

@stop
