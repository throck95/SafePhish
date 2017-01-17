@extends('masters.basemaster')
@section('content')
    <!--This is a Phishing Email sponsored by {{ $companyName }} to test your awareness of Phishing Scams. Project Name: {{ $projectName }}-->
    <!-- Facebook Scam -->
    <!-- use facebook_header.png in the header of email -->
    <p><strong>Hi {{$firstName}},</strong></p>
    <p>A friend invited you to like <!--Make look like hyperlink? -->Tasty</p>
    <!-- Use the facebook emails to template this from an image -->
    <p>Thanks,<br />
    Tasty</p>
    <!--webbug here-->
    <!--{!! HTML::image('http://i.imgur.com/2MuTWFy.jpg') !!}-->
    {!! HTML::image('http://localhost:8888/path/to/image.png') !!}
@stop