@extends('masters.basemaster')
@section('title')
    Create New Campaign Email Address
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Create New Campaign Email Address</h3>
    {!! Form::open(array('url'=>'/campaign/emails')) !!}
    <p>{!! Form::label('nameText','Name: ') !!}
        {!! Form::text('nameText',null,array('name'=>'nameText')) !!}</p>
    <p>{!! Form::label('emailText','Email: ') !!}
        {!! Form::text('emailText',null,array('name'=>'emailText')) !!}</p>
    <p>{!! Form::label('passwordText','Password: ') !!}
        {!! Form::password('passwordText',null,array('name'=>'passwordText')) !!}</p>
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
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop