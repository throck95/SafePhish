@extends('masters.basemaster')
@section('content')
    <!--This is a Phishing Email sponsored by {{ $companyName }} to test your awareness of Phishing Scams. Project Name: {{ $projectName }}-->
    <p>Good Morning!</p>
    <p>We are making sure you are aware of the benefits that are provided to you. There have been recent updates to
    these policies that could impact your eligibility to receive 401(k) Matching, Health or Dental Benefits, and other services.</p>

   <p>You can check <a href="">here</a> to see how these changes may affect you.</p>

    <p>Thank you,<br />
        HR Rep Name found on LinkedIn</p>

    <!--webbug here-->
    <!--{!! HTML::image('http://i.imgur.com/2MuTWFy.jpg') !!}-->
    {!! HTML::image('http://localhost:8888/path/to/image.png') !!}
@stop