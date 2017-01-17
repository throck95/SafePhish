@extends('masters.basemaster')
@section('title')
    Login
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/testUserAuth.js"></script>
@stop
@section('formcss')
    <link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />
@stop
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="/css/loginErrors.css" />
@stop
@section('bodyContent')
    <div id="errorsDiv">
        @foreach($errors as $error)
            <p class="fa fa-times-circle">{{ $error }}</p>
        @endforeach
    </div>
    {!! Form::open(array('url'=>'/login')) !!}
    <p>{!! Form::text('usernameText',null,array('id'=>'usernameText','placeholder'=>'Username','name'=>'usernameText')) !!}</p>
    <p>{!! Form::password('passwordText',array('id'=>'passwordText','placeholder'=>'Password','name'=>'passwordText')) !!}</p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop