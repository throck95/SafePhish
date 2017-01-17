@extends('masters.basemaster')
@section('content')
    <!--This is a Phishing Email sponsored by {{ $companyName }} to test your awareness of Phishing Scams. Project Name: {{ $projectName }}-->
    <!-- Black Friday Scam -->
    <!-- use black_friday1.png and put it inside an <a> tag that links to immediate explanation that it was phishing -->
    <!--webbug here-->
    <!--{!! HTML::image('http://i.imgur.com/2MuTWFy.jpg') !!}-->
    {!! HTML::image('http://localhost:8888/path/to/image.png') !!}
@stop