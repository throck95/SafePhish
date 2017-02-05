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
    <p>{!! Form::label('departmentSelect','Department: ') !!}
        <select id='departmentSelect' name='departmentSelect[]' multiple>
            @for ($i = 0; $i < count($departments); $i++)
                <option value="{{ $departments[$i]->Id }}">{{ $departments[$i]->Department }}</option>
            @endfor
        </select></p>
    <br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop