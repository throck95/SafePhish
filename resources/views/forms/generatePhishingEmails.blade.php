@extends('masters.basemaster')
@section('title')
    Send Phishing Emails
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/phishingEmailBasic.js"></script>
@stop
@section('bodyContent')
    {!! Form::open(array('route'=>'sendPhish')) !!}
    <datalist id="usersDatalist">
        @for ($i = 0; $i < count($users); $i++)
            <option value="{{ $users[$i]->Id }}">
                {{ $users[$i]->FirstName }} {{ $users[$i]->LastName }}</option>
        @endfor
    </datalist>
    <datalist id="groupsDatalist">
        @for ($i = 0; $i < count($groups); $i++)
            <option value="{{ $groups[$i]->Id }}">
                {{ $groups[$i]->Department }}</option>
        @endfor
    </datalist>
    <datalist id="campaignsDatalist">
        @for ($i = 0; $i < count($campaigns); $i++)
            <option value="{{ $campaigns[$i]->Id }}">
                {{ $campaigns[$i]->Name }}</option>
        @endfor
    </datalist>
    <datalist id="templatesDatalist">
        @for ($i = 0; $i < count($templates); $i++)
            <option value="{{ $templates[$i]->FileName }}">
                {{ $templates[$i]->PublicName }}</option>
        @endfor
    </datalist>
    <datalist id="emailsDatalist">
        @for ($i = 0; $i < count($emails); $i++)
            <option value="{{ $emails[$i]->EmailAddress }}">
                {{ $emails[$i]->Name }} - {{ $emails[$i]->EmailAddress }}</option>
        @endfor
    </datalist>
    <p>
        <input type="radio" id="userRadio" name="sendingChoiceRadio" value="user" checked /> User <br />
        <input type="radio" id="groupRadio" name="sendingChoiceRadio" value="group" /> Group <br />
    </p>
    <p>
        {!! Form::label('userIdText','User: ') !!}
        {!! Form::text('userIdText',null,array('name'=>'userIdText','list'=>'usersDatalist')) !!}
    </p>
    <p>
        {!! Form::label('groupIdText','Group: ') !!}
        {!! Form::text('groupIdText',null,array('name'=>'groupIdText','list'=>'groupsDatalist','class'=>'disabled')) !!}
    </p>
    <p>
        {!! Form::label('fromEmailText','From: ') !!}
        {!! Form::text('fromEmailText',null,array('name'=>'fromEmailText','list'=>'emailsDatalist')) !!}
    </p>
    <p>
        {!! Form::label('companyText','Company Name: ') !!}
        {!! Form::text('companyText',null,array('name'=>'companyText')) !!}
    </p>
    <p>
        {!! Form::label('campaignText','Campaign: ') !!}
        {!! Form::text('campaignText',null,array('name'=>'campaignText','list'=>'campaignsDatalist')) !!}
    </p>
    <p>
        {!! Form::label('templateText','Template: ') !!}
        {!! Form::text('templateText',null,array('name'=>'templateText','list'=>'templatesDatalist')) !!}
    </p>
    {!! Form::submit('Send',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop