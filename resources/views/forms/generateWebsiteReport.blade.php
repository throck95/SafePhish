@extends('masters.basemaster')
@section('title')
    Generate Email Report
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('formcss')
    <link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />
@stop
@section('bodyContent')
    {!! Form::open(array('action'=>'DataController@websiteTrackingCSV')) !!}
    <p>{!! Form::label('campaignIdSelect','Campaign: ') !!}
        <select id='campaignIdSelect' name='campaignIdSelect'>
            <option disabled selected value>-- Select an ID --</option>
            @for ($i = 0; $i < count($campaigns); $i++)
                <option value="{{ $campaigns[$i]->Id }}">
                    {{ $campaigns[$i]->Name }}</option>
            @endfor
        </select></p>
    <datalist id="usersDatalist">
        @for ($i = 0; $i < count($users); $i++)
            <option value="{{ $users[$i]->Id }}">
                {{ $users[$i]->FirstName }} {{ $users[$i]->LastName }}</option>
        @endfor
    </datalist>
    <p>{!! Form::label('userIdText','Mailing User ID: ') !!}
        {!! Form::text('userIdText',null,array('name'=>'userIdText','list'=>'usersDatalist')) !!}</p>
    <p>{!! Form::label('ipText','IP Address: ') !!}
        {!! Form::text('ipText',null,array('name'=>'ipText')) !!}
    <label class="switch">
        IP Exact:
        <input type="checkbox" id="ipExactToggle" name="ipExactToggle" checked />
        <div class="slider round"></div>
    </label></p>
    <p>{!! Form::label('timestampStart','Start: ') !!}
        <input type="datetime-local" id="timestampStart" name="timestampStart" step="10" /></p>
    <p>{!! Form::label('timestampEnd','End: ') !!}
        <input type="datetime-local" id="timestampEnd" name="timestampEnd" step="10" /></p>
    {!! Form::submit('Generate Report',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop