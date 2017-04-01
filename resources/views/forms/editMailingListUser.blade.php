@extends('masters.basemaster')
@section('title')
    Edit Mailing List User
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Edit Mailing List User</h3>
    {!! Form::open(array('url'=>"/mailinglist/update/user/$mlu->id")) !!}
    <p>
    <p>{!! Form::label('firstNameText','First Name: ') !!}
        {!! Form::text('firstNameText',$mlu->first_name,array('name'=>'firstNameText')) !!}</p>
    <p>{!! Form::label('lastNameText','Last Name: ') !!}
        {!! Form::text('lastNameText',$mlu->last_name,array('name'=>'lastNameText')) !!}</p>
    <p>{!! Form::label('emailText','Email: ') !!}
        {!! Form::text('emailText',$mlu->email,array('name'=>'emailText')) !!}</p>
    <p>{!! Form::label('groupSelect','Group: ') !!}
        <select id='groupSelect' name='groupSelect[]' multiple>
            @for ($i = 0; $i < count($groups); $i++)
                <option value="{{ $groups[$i]->id }}">{{ $groups[$i]->name }}</option>
            @endfor
        </select></p>
    <p>{!! Form::label('urlToggle','Generate New URL Id: ') !!}
        <input type="checkbox" name="urlToggle" checked /></p>
    {!! Form::submit('Update User',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop