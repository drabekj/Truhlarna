@extends('master')

@section('title', 'Test')

@section('content')
<h1>Tesing page</h1>

  <div>
    <input type="text" ng-model="yourName" placeholder="Enter your name">
    <h1><% yourName %></h1>
  </div>


@stop
