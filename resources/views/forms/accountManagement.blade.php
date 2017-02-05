@extends('masters.basemaster')
@section('title')
    Account Management
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop
@section('stylesheets')

@stop
@section('bodyContent')
    {!! Form::open(array('route'=>'updateUser')) !!}
    <p>
    <p>{!! Form::label('firstNameLbl','First Name: ') !!}
        {!! Form::label(null,"$user->FirstName $user->MiddleInitial",array('id'=>'firstNameLbl')) !!}</p>
    <p>{!! Form::label('lastNameLbl','Last Name: ') !!}
        {!! Form::label(null,$user->LastName,array('id'=>'lastNameLbl')) !!}</p>
    <p>{!! Form::label('usernameLbl','Username: ') !!}
        {!! Form::label(null,$user->Username,array('id'=>'usernameLbl')) !!}</p>
    <p>{!! Form::label('emailText','Email: ') !!}
        {!! Form::text('emailText',$user->Email,array('name'=>'emailText')) !!}</p>
    <p>{!! Form::label('passwordText','Password: ') !!}
        {!! Form::password('passwordText',array('id'=>'passwordText','name'=>'passwordText','size'=>30)) !!}</p>
    <p>{!! Form::label('passwordVerifyText','Password Verify: ') !!}
        {!! Form::password('passwordVerifyText',array('id'=>'passwordVerifyText','name'=>'passwordVerifyText','size'=>30)) !!}</p>
    <p>{!! Form::label('2faToggle','Enable/Disable Two-Factor Authentication: ') !!}
        <input type="checkbox" name="2faToggle" checked /></p>
    {!! Form::submit('Update Account',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop