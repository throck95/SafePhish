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
    <p>{!! Form::label('groupSelect','Groups: ') !!}
        <select id='groupSelect' name='groupSelect[]' multiple>
            @for ($i = 0; $i < count($groups); $i++)
                <option value="{{ $groups[$i]->id }}">{{ $groups[$i]->name }} - {{ $groups[$i]->company_name }}</option>
            @endfor
        </select></p>
    <br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop
@section('footer')
    <p></p>
@stop