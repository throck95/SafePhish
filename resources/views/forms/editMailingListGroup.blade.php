@extends('masters.basemaster')
@section('title')
    Edit Mailing List Group
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('bodyContent')
    {!! Form::open(array('url'=>"/mailinglist/update/group/$group->id")) !!}
    <p>{!! Form::label('nameText','Name: ') !!}
        {!! Form::text('nameText',$group->name,array('name'=>'nameText')) !!}</p>
    <p>{!! Form::label('userSelect','Users: ') !!}
        <select id='userSelect' name='userSelect[]' multiple>
            @for ($i = 0; $i < count($users); $i++)
                <option value="{{ $users[$i]->id }}">{{ $users[$i]->first_name }} {{ $users[$i]->last_name }}</option>
            @endfor
        </select></p>
    <br /><br />
    {!! Form::submit('Update Group',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop