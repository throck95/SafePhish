@extends('masters.basemaster')
@section('title')
    Create New Campaign
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/createNewCampaign.js"></script>
@stop
@section('formcss')
    <link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />
@stop
@section('campaignsClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    {!! Form::open(array('action'=>'PhishingController@createNewCampaign')) !!}
    <p>{!! Form::label('campaignNameText','Campaign Name: ') !!}
        {!! Form::text('campaignNameText',null,array('name'=>'campaignNameText')) !!}</p>
    <p>{!! Form::label('campaignAssigneeText','Campaign Assignee: ') !!}
        {!! Form::text('campaignAssigneeText',null,array('name'=>'campaignAssigneeText')) !!}</p>
    <p>{!! Form::label('campaignComplexityType','Campaign Complexity: ') !!}
        <select id="campaignComplexityType" name="campaignComplexityType">
            <option value="adv">Advanced</option>
            <option value="gen">Basic</option>
        </select></p>
    <p>{!! Form::label('campaignTargetType','Campaign Target: ') !!}
        <select id="campaignTargetType" name="campaignTargetType">
            <option value="T">Targeted</option>
            <option value="G">Generic</option>
        </select></p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop