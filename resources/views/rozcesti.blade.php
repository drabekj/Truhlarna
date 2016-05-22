@extends('master')

@section('title', 'Rozcestí')

@section('content')

<style type="text/css">
    .skryte{
        display:none;
    }

    ul:hover .skryte{
        display: block;
        text-align:center;
        padding-top:1em;
    }

    ul{
       list-style-type:none;
    }

    ul:not(.nav):hover{
        padding-bottom:2em;
    }
    
    input{
        width:60%;
        height:2em;
    }

    .validate_error{
      margin: auto;
      width: 60%;
      padding: 0.7em;
      text-align: center;
    }

</style>

<div class="container">
  <div class="visible_for_all">
    <div class="col-md-4 col-md-offset-4 pagination-centered">
        <ul>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('pracovniVykaz') }}">
                {!! csrf_field() !!}
            <li class="show">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Vyplnění pracovního výkazu
                </button>
            </li>
            <li class="skryte"><input type="username" name="username" placeholder="Uživatelské ID" required></li>
            <!--<li class="skryte">{{ Form::select('ids', $truhlari, null, array('class' => 'form-control')) }}</li>-->
            @if (count($errors) > 0)
             <div class="help-block validate_error alert-warning">
                  <strong class="validate_error_text">Pracovník neexistuje.</strong>
              </div>
            @endif
            <li class="skryte"><input type="month" name="datumPracvykaz" required></li>
            <!--type month je v html5 ktery firefox nepodporuje, nutno urpavit-->
            </form>
        </ul>
        <ul>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('ukolovaMzda') }}">
                {!! csrf_field() !!}
            <li class="show">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Generování úkolové mzdy
                </button>
            </li>
            <li class="skryte"><input type="month" name="datumUklMzda" required></li>
            <!--type month je v html5 ktery firefox nepodporuje, nutno urpavit-->
            </form>
        </ul>
        <ul>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('odvadeciVykaz') }}">
                {!! csrf_field() !!}
                <li class="show">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Odváděcí výkaz
                    </button>
                </li>
                <li class="skryte"><input type="month" name="datumOdVykaz" required></li>
                <!--type month je v html5 ktery firefox nepodporuje, nutno urpavit-->
             </form>
        </ul>
    </div>
  </div>
    
  
  @if (Auth::User()->role == 'admin')
  <div class="col-md-4 col-md-offset-4">
    <hr>
    <ul>
    <a href="{{action('HomeController@register')}}"
    class="btn btn-primary btn-lg btn-block">Registrace nového uživatele</a>
    <a href="{{action('HomeController@deleteUser')}}"
    class="btn btn-primary btn-lg btn-block">Smazání uživatele</a>
    </ul>
  </div>
  @endif
</div>
<div>
  <!--vypsani oznameni o odstraneni uzivatele-->
  @if(Session::has('success'))
    <div class="alert alert-success col-md-4 col-md-offset-4">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Úspěch!</strong> {{ Session::get('message', '') }}
    </div>
    @endif
</div>
@stop
