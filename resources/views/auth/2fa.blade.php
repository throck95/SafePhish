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

@stop
@section('bodyContent')
    <div id="errorsDiv">
        @foreach($errors as $error)
            <p class="fa fa-times-circle">{{ $error }}</p>
        @endforeach
    </div>
    {!! Form::open(array('url'=>'/2fa')) !!}
    <p>{!! Form::text('codeText',null,array('id'=>'codeText','placeholder'=>'Authentication Code','name'=>'codeText')) !!}</p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop