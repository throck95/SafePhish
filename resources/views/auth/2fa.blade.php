@extends('masters.basemaster')
@section('title')
    SafePhish - Authentication Verification
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('formcss')

@stop
@section('stylesheets')
    <link href="/css/2fa.css" type="text/css" rel="stylesheet" />
@stop
@section('bodyContent')
    <h2 style="margin: auto; text-align: center">Two-Factor Authentication</h2>
    <br />
    {!! Form::open(array('url'=>'/2fa')) !!}
    <div><strong style="float: left; width: 40%">Authentication code</strong><a href="#whatsthis" style="float: right; width: 30%; text-decoration: none">What's this?</a></div>
    <div>{!! Form::text('codeText',null,array('id'=>'codeText','name'=>'codeText','style'=>'width:90%')) !!}</div>
    {!! Form::submit('Verify',array('id'=>'submitButton','style'=>'width:80%')) !!}
    {!! Form::close() !!}
    <br />
    <div style="width: 40%; margin: auto">
        <p>Open the two-factor authentication email sent to your primary email address
            to view your authentication code and verify your identity.</p>
        <br />
        <p><a href="/2faresend" style="text-decoration: none">Resend Code</a></p>
    </div>
    <br />
    <hr width="75%" />
    <br />
    <div style="width: 40%; margin: auto">
        <p><strong>Don't have access to your email?</strong></p>
        <p><a href="#recoverycode">Enter a two-factor recovery code</a></p>
    </div>
    <br />
@stop