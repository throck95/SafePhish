@extends('masters.basemaster')
@section('title')
    Login
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/login_validateInput.js"></script>
@stop
@section('formcss')

@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h2 style="margin-left: 10px; font-weight: 300">Log In</h2>
    {!! Form::open(array('url'=>'/login')) !!}
    <p>{!! Form::label('emailText','Username: ') !!}
        {!! Form::text('emailText',null,array('id'=>'emailText','name'=>'emailText','size'=>30, 'autofocus')) !!}</p>
    <p>{!! Form::label('passwordText','Password: ') !!}
        {!! Form::password('passwordText',array('id'=>'passwordText','name'=>'passwordText','size'=>30)) !!}</p>
    {!! Form::submit('Login',array('id'=>'submitButton','style'=>'margin-left:10px')) !!}
    {!! Form::close() !!}
@stop