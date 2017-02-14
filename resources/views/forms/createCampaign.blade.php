@extends('masters.basemaster')
@section('title')
    Create New Campaign
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Create New Campaign</h3>
    {!! Form::open(array('route'=>'createCampaign')) !!}
    <datalist id="usersDatalist">
        @for ($i = 0; $i < count($users); $i++)
            <option value="{{ $users[$i]->id }}">
                {{ $users[$i]->first_name }} {{ $users[$i]->last_name }}</option>
        @endfor
    </datalist>
    <p>{!! Form::label('nameText','Name: ') !!}
        {!! Form::text('nameText',null,array('name'=>'nameText')) !!}</p>
    <p>{!! Form::label('descriptionText','Description: ') !!}
        <textarea id="descriptionText" name="descriptionText" rows="4" cols="50"></textarea></p>
    <p>{!! Form::label('assigneeText','Campaign Assignee: ') !!}
        {!! Form::text('assigneeText',null,array('name'=>'assigneeText','list'=>'usersDatalist')) !!}</p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop