@extends('master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Odebrání uživatele</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/delete') }}">
                        {!! csrf_field() !!}
                        {{ Form::hidden('_method', 'DELETE') }}
                        <div class="form-group-row">
                            {{ Form::select('ids', $zamestnanci, null, array('class' => 'form-control')) }}
                        </div>
                        <p>
                        </p>
                        <div class="form-group{{ $errors->any() ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Heslo</label>

                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password">
                      
                                @if ($errors->any())
                                    <span class="help-block">
                                        <strong>Nesprávné heslo</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Odebrat
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
