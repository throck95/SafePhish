@extends('masters.basemaster')
@section('title')
    Generate Emails Form
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/phishingEmailBasic.js"></script>
@stop
@section('formcss')
    <!--<link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />-->
@stop
@section('emailClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('contentViewer')
    <div id="templateContentDiv"></div>
@stop
@section('bodyContent')
    {!! Form::open(array('route'=>'sendEmail')) !!}
    <p>{!! Form::label('mailServerText','Mail Server: ') !!}
        <input type="text" id="mailServerText" name="mailServerText" value="{{ $dft_host }}" /></p>
    <p>{!! Form::label('mailPortText','Mail Port: ') !!}
        <input type="text" id="mailPortText" name="mailPortText" value="{{ $dft_port }}" /></p>
    <p>{!! Form::label('projectNameSelect','Project Name: ') !!}
        <select id='projectNameSelect' name='projectData' onchange="getProject(this)">
            <option value="-1">--Default--</option>
            @for ($i = 0; $i < count($projects); $i++)
                <option value="{{ $projects[$i]->PRJ_Id }}">
                    {{ $projects[$i]->PRJ_Name }} ({{ $projects[$i]->PRJ_Status }})</option>
            @endfor
            <option value="0">Create New</option>
        </select></p>
    <p>{!! Form::label('emailTemplateSelect','Email Templates: ') !!}
        <select id='emailTemplateSelect' name='emailTemplate' onchange="getTemplateData(this);">
            <option value="-1">--Default--</option>
            @for ($i = 0; $i < count($templates); $i++)
                <option value="{{ $templates[$i] }}">{{ $templates[$i] }}</option>
            @endfor
            <option value="0">Create New</option>
        </select></p>
    <p>{!! Form::label('fromEmailText','From E-Mail: ') !!}
        <input type="text" id="fromEmailText" name="fromEmailText" value="{{ $dft_user }}" /></p>
    <p>{!! Form::label('passwordText','E-Mail Password (optional): ') !!}
        {!! Form::password('passwordText',null,array('name'=>'fromPass')) !!}</p>
    <p>{!! Form::label('subjectText','Subject: ') !!}
        {!! Form::text('subjectText', null, array('name'=>'subject')) !!}</p>
    <p>{!! Form::label('companyText','Company Name: ') !!}
        <input type="text" id="companyText" name="companyText" value="{{ $dft_company }}" /></p>
    <!-- emailTemplate (select) --><br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop