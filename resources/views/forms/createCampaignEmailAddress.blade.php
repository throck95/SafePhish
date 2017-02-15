@extends('masters.basemaster')
@section('title')
    Create New Campaign Email Address
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Create New Campaign Email Address</h3>
    {!! Form::open(array('url'=>'/campaign/emails')) !!}
    <p>{!! Form::label('nameText','Name: ') !!}
        {!! Form::text('nameText',null,array('name'=>'nameText')) !!}</p>
    <p>{!! Form::label('emailText','Email: ') !!}
        {!! Form::text('emailText',null,array('name'=>'emailText')) !!}</p>
    <p>{!! Form::label('passwordText','Password: ') !!}
        {!! Form::password('passwordText',null,array('name'=>'assigneeText')) !!}</p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop