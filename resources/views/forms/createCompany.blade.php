@extends('masters.basemaster')
@section('title')
    Create New Company
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Create New Company</h3>
    {!! Form::open(array('route'=>'createCompany')) !!}
    <p>{!! Form::label('companyText','Company Name: ') !!}
        {!! Form::text('companyText',null,array('name'=>'companyText')) !!}</p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop