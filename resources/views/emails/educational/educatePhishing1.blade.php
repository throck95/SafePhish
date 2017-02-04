@extends('masters.basemaster')
@section('content')
    <!--This is a Phishing Educational Email sponsored by GAIG. Project Name: {{ $projectName }}-->
    <p>Good Morning Everyone!</p>
    <p>Phishing emails are a constant threat to businesses all over the world. For us, it’s no different. Last year,
        there was an estimated 31 billion spam emails sent out worldwide. This number is only expected to grow in the
        coming years.</p><br />

    <h4>What is a phishing email?</h4>
    <p>The Federal Trade Commission describes phishing as individuals that impersonate a business to trick you into
        giving out your personal or corporate information. These scams happen every day. The best solution is to
        ignore them. However, if you are concerned about your account, it’s never a bad idea to reach out to your
        organization to assure that your assets are safe.</p>

    <p>Thank you,<br />
        Annuity IT Service Desk<br /><br />
        Phone: 513-412-1234
        Email: <a href="mailto:helpdesk@gaig.com">helpdesk@gaig.com</a></p>

    <!--webbug here-->
    <!--{!! HTML::image('http://i.imgur.com/2MuTWFy.jpg') !!}-->
    {!! HTML::image('http://localhost:8888/path/to/image.png') !!}
@stop