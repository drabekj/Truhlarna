@extends('master')

@section('title', 'Test')

@section('content')
<h1>Tesing page</h1>

  <div>
    <input type="text" ng-model="yourName" placeholder="Enter your name">
    <h1><% yourName %></h1>
  </div>

  <hr>

  {{-- for ($row = 0; $row < $numOfRows; $row++) {
      for ($col = 0; $col < $numOfCols; $col++) { --}}

      {{-- <ul>
       <li ng-repeat="phone in phones">
         <span>{{phone.name}}</span>
         <p>{{phone.snippet}}</p>
       </li>
     </ul> --}}

     <div ng-controller="customersCtrl">

    <table>
     <tr ng-repeat="x in names">
       <td><% x.Name %></td>
       <td><% x.Country %></td>
     </tr>
    </table>

    </div>

@stop
