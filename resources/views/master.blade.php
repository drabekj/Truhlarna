<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta name="description" content="Semestralni prace - SP1 - FIT CVUT">
        <meta name="keywords" content="HTML,CSS,JavaScript,PHP,Laravel,SQL">
        <meta name="authors" content="Lukas Bunat, Jan Drabek, Jan Zimolka, Jan Parma">
    </head>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

    </style>
    
    <h1>@yield('heading')</h1>
    <body>
    <nav class="navbar navbar-default navbar-static-top">
    <div class="navbar-header">

    <!-- Branding Image -->
    <p class="navbar-brand">Truhlarna</p>
     @yield('loggedAs')
    </div>
    </nav>
    <div class="container">
    @yield('content')
    </div>

    </body>
</html>