@extends('masters.basemaster')
@section('title')
    Register User
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Register User</h3>
    @include('includes.errors_include')
    {!! Form::open(array('route'=>'register')) !!}
    <p>
    <p>{!! Form::label('emailText','Email: ') !!}
        {!! Form::text('emailText',null,array('name'=>'emailText')) !!}</p>
    <p>{!! Form::label('confirmEmailText','Confirm Email: ') !!}
        {!! Form::text('confirmEmailText',null,array('name'=>'confirmEmailText')) !!}</p>
    <p>{!! Form::label('firstNameText','First Name: ') !!}
        {!! Form::text('firstNameText',null,array('name'=>'firstNameText')) !!}</p>
    <p>{!! Form::label('lastNameText','Last Name: ') !!}
        {!! Form::text('lastNameText',null,array('name'=>'lastNameText')) !!}</p>
    <p>{!! Form::label('middleInitialText','Middle Initial: ') !!}
        {!! Form::text('middleInitialText',null,array('name'=>'middleInitialText','maxlength'=>1)) !!}</p>
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
    <p>
        {!! Form::label('permissionsSelect','Permissions: ') !!}
        <select id='permissionsSelect' name='permissionsSelect[]' multiple>
            @for ($i = 0; $i < count($permissions); $i++)
                <option value="{{ $permissions[$i]->id }}">{{ $permissions[$i]->permission_type }}</option>
            @endfor
        </select>
    </p>
    {!! Form::submit('Register',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop