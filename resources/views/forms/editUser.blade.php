@extends('masters.basemaster')
@section('title')
    Edit User
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h3 style="font-weight: 300">Edit User</h3>
    {!! Form::open(array('url'=>"/user/update/$user->Id")) !!}
    <p>
    <p>{!! Form::label('usernameLbl','Username: ') !!}
        {!! Form::label(null,$user->Username,array('id'=>'usernameLbl')) !!}</p>
    <p>{!! Form::label('firstNameLbl','First Name: ') !!}
        {!! Form::label(null,"$user->FirstName $user->MiddleInitial",array('id'=>'firstNameLbl')) !!}</p>
    <p>{!! Form::label('lastNameLbl','Last Name: ') !!}
        {!! Form::label(null,$user->LastName,array('id'=>'lastNameLbl')) !!}</p>
    <p>{!! Form::label('2faLbl','Two-Factor Authentication: ') !!}
        {!! Form::label(null,$twoFactor,array('id'=>'2faLbl')) !!}</p>
    <p>{!! Form::label('emailText','Email: ') !!}
        {!! Form::text('emailText',$user->Email,array('name'=>'emailText')) !!}</p>
    <datalist id="permissionsDatalist">
        @for ($i = 0; $i < count($permissions); $i++)
            <option value="{{ $permissions[$i]->Id }}">
                {{ $permissions[$i]->PermissionType }}</option>
        @endfor
    </datalist>
    <p>{!! Form::label('permissionsText','Permissions: ') !!}
        {!! Form::text('permissionsText',$user->UserType,array('name'=>'permissionsText','datalist'=>'permissionsDatalist')) !!}</p>
    <p>{!! Form::label('passwordToggle','Reset Password: ') !!}
        <input type="checkbox" name="passwordToggle" checked /></p>
    {!! Form::submit('Update User',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop