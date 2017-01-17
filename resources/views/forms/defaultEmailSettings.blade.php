@extends('masters.basemaster')
@section('title')
    Generate Emails Form
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('formcss')
    <link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />
@stop
@section('emailClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    {!! Form::open(array('action'=>'PhishingController@updateDefaultEmailSettings')) !!}
    <p>{!! Form::label('mailServerText','Mail Server: ') !!}
        <input type="text" id="mailServerText" name="mailServerText" value="{{ $dft_host }}" /></p>
    <p>{!! Form::label('mailPortText','Mail Port: ') !!}
        <input type="text" id="mailPortText" name="mailPortText" value="{{ $dft_port }}" /></p>
    <p>{!! Form::label('usernameText','Username: ') !!}
        <input type="text" id="usernameText" name="usernameText" value="{{ $dft_user }}" /></p>
    <p>{!! Form::label('companyText','Company Name: ') !!}
        <input type="text" id="companyText" name="companyText" value="{{ $dft_company }}" /></p>
    <!-- emailTemplate (select) --><br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop