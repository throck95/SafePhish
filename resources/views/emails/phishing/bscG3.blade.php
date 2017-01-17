@extends('masters.basemaster')
@section('content')
    <!--This is a Phishing Email sponsored by {{ $companyName }} to test your awareness of Phishing Scams. Project Name: {{ $projectName }}-->
    <!-- Scholarship Scam -->
    <!-- use tuition_chart1.png -->
    <!--webbug here-->
    <!--{!! HTML::image('http://i.imgur.com/2MuTWFy.jpg') !!}-->
    {!! HTML::image('http://localhost:8888/path/to/image.png') !!}
@stop