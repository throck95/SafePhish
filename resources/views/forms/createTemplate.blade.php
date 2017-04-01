@extends('masters.basemaster')
@section('title')
    Create New Template
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Create New Template</h3>
    {!! Form::open(array('route'=>'createTemplate')) !!}
    <p>{!! Form::label('fileNameText','File Name: ') !!}
        {!! Form::text('fileNameText',null,array('name'=>'fileNameText')) !!}</p>
    <p>{!! Form::label('publicNameText','Public Name: ') !!}
        {!! Form::text('publicNameText',null,array('name'=>'publicNameText')) !!}</p>
    <p>{!! Form::label('typeSelect','Email Type: ') !!}
        <select id="typeSelect" name="typeSelect">
            <option value="phishing">Phishing</option>
            <option value="education">Education</option>
        </select></p>
    <p>{!! Form::label('mailableText','Mailable: ') !!}
        {!! Form::text('mailableText',null,array('name'=>'mailableText')) !!}</p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop