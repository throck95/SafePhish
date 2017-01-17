@extends('masters.basemaster')
@section('title')
    Add New Mailing List User
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <!--<script type="text/javascript" src="/js/emailRequirements.js"></script>-->
@stop
@section('formcss')
    <!--<link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />-->
@stop
@section('emailClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    {!! Form::open(array('route'=>'postMailingListUser')) !!}
    <p>{!! Form::label('usernameText','Username: ') !!}
        <input type="text" id="usernameText" name="usernameText" /></p>
    <p>{!! Form::label('emailText','Email Address: ') !!}
        <input type="text" id="emailText" name="emailText" /></p>
        <p>{!! Form::label('firstNameText','First Name: ') !!}
        <input type="text" id="firstNameText" name="firstNameText" /></p>
    <p>{!! Form::label('lastNameText','Last Name: ') !!}
        <input type="text" id="lastNameText" name="lastNameText" /></p>
    <p>{!! Form::label('departmentSelect','Department: ') !!}
        <select id='departmentSelect' name='departmentSelect'>
            <option value="-1">--Default--</option>
            @for ($i = 0; $i < count($departments); $i++)
                <option value="{{ $departments[$i]->MLD_Id }}">{{ $departments[$i]->MLD_Department }}</option>
            @endfor
            <option value="0">Create New</option>
        </select></p>
    <p>{!! Form::label('createNewDepartmentText','New Department: ',array('style'=>'visibility: visible')) !!}
        <input type="text" id="createNewDepartmentText" name="createNewDepartmentText" style="visibility: visible"/></p>
    <br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop