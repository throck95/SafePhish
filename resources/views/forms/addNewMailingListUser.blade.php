@extends('masters.basemaster')
@section('title')
    Add New Mailing List User
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('formcss')

@stop
@section('bodyContent')
    {!! Form::open(array('route'=>'postMailingListUser')) !!}
    <p>{!! Form::label('emailText','Email Address: ') !!}
        {!! Form::text('emailText',null,array('name'=>'emailText')) !!}</p>
        <p>{!! Form::label('firstNameText','First Name: ') !!}
            {!! Form::text('firstNameText',null,array('name'=>'firstNameText')) !!}</p>
    <p>{!! Form::label('lastNameText','Last Name: ') !!}
        {!! Form::text('lastNameText',null,array('name'=>'lastNameText')) !!}</p>
    <p>{!! Form::label('groupSelect','Groups: ') !!}
        <select id='groupSelect' name='groupSelect[]' multiple>
            @for ($i = 0; $i < count($groups); $i++)
                <option value="{{ $groups[$i]->id }}">{{ $groups[$i]->name }}</option>
            @endfor
        </select></p>
    <br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop