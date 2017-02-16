@extends('masters.basemaster')
@section('title')
    Edit Mailing List Group
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('bodyContent')
    {!! Form::open(array('route'=>'postMailingListGroup')) !!}
    <p>{!! Form::label('nameText','Name: ') !!}
        {!! Form::text('nameText',null,array('name'=>'nameText')) !!}</p>
    @if(\App\Http\Controllers\AuthController::safephishAdminCheck())
        <datalist id="companiesDatalist">
            @for ($i = 0; $i < count($companies); $i++)
                <option value="{{ $companies[$i]->id }}">
                    {{ $companies[$i]->name }}</option>
            @endfor
        </datalist>
        <p>{!! Form::label('companyText','Company: ') !!}
            {!! Form::text('companyText',null,array('name'=>'companyText','list'=>'companiesDatalist')) !!}</p>
    @endif
    <p>{!! Form::label('userSelect','Users: ') !!}
        <select id='userSelect' name='userSelect[]' multiple>
            @for ($i = 0; $i < count($users); $i++)
                <option value="{{ $users[$i]->id }}">{{ $users[$i]->first_name }} {{ $users[$i]->last_name }}</option>
            @endfor
        </select></p>
    <br /><br />
    {!! Form::submit('Create Group',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop