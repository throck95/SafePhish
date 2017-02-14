@extends('masters.basemaster')
@section('title')
    Edit Campaigns
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">{{ $campaign->name }}</h3>
    <h5 style="font-weight: 300">Campaign Manager: {{ $user->first_name }} {{ $user->last_name }}</h5>
    {!! Form::open(array('url'=>"/campaigns/update/$campaign->id")) !!}
    <p>
    <datalist id="usersDatalist">
        @for ($i = 0; $i < count($users); $i++)
            <option value="{{ $users[$i]->Id }}">
                {{ $users[$i]->first_name }} {{ $users[$i]->last_name }}</option>
        @endfor
    </datalist>
    <p>{!! Form::label('descriptionText','Description: ') !!}
        <textarea id="descriptionText" name="descriptionText" rows="4" cols="50">{{ $campaign->description }}</textarea></p>
    <p>{!! Form::label('userIdText','Campaign Manager: ') !!}
        {!! Form::text('userIdText',$user->id,array('name'=>'userIdText','list'=>'usersDatalist')) !!}</p>
    <p>{!! Form::label('statusSelect','Status: ') !!}
        <select id='statusSelect' name='statusSelect'>
            <option value="active" @if($campaign->status === 'active') selected @endif>Active</option>
            <option value="inactive" @if($campaign->status === 'inactive') selected @endif>Inactive</option>
        </select></p>
    {!! Form::submit('Update Campaign',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop