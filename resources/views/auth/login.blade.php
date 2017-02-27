@extends('masters.basemaster')
@section('title')
    Login
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
@stop
@section('formcss')

@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h2 style="margin-left: 10px; font-weight: 300">Log In</h2>
    {!! Form::open(array('url'=>'/login')) !!}
    <p>{!! Form::label('emailText','Username: ') !!}
        {!! Form::text('emailText',null,array('id'=>'emailText','name'=>'emailText','size'=>30, 'autofocus', 'required')) !!}</p>
    <p>{!! Form::label('passwordText','Password: ') !!}
        {!! Form::password('passwordText',array('id'=>'passwordText','name'=>'passwordText','size'=>30, 'required')) !!}</p>
    <div class="g-recaptcha" data-sitekey="6Lf8BhcUAAAAAH5ZaUuKT6VYC6VDycjbPyQ0eBsq"></div>
    {!! Form::submit('Login',array('id'=>'submitButton','style'=>'margin-left:10px')) !!}
    {!! Form::close() !!}
@stop