<html>
<head>
    <title>Generate Emails Form</title>
    <meta name="_token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
<div class="rootContainer">{!! Form::open(array('url'=>'/register')) !!}
    {!! Form::text('firstNameText',null,array('name'=>'firstNameText')) !!}
    {!! Form::text('lastNameText',null,array('name'=>'lastNameText')) !!}
    {!! Form::text('initialText',null,array('name'=>'initialText','maxlength'=>1)) !!}
    {!! Form::text('emailText',null,array('name'=>'emailText')) !!}
    {!! Form::text('usernameText',null,array('name'=>'usernameText')) !!}
    {!! Form::password('passwordText',array('name'=>'passwordText')) !!}
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
{!! Form::close() !!}
</div>
<footer>
    <p></p>
</footer>
</body>
</html>