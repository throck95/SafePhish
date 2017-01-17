@extends('masters.basemaster')
@section('content')
    <!--This is a Phishing Email sponsored by {{ $companyName }} to test your awareness of Phishing Scams. Project Name: {{ $projectName }}-->
<p>Mr. or Mrs. {{ $lastName }}: </p>
<p>There have been numerous login attempts to your corporate account, {{ $username }}.</p>

<p>2016-05-25T01:37:24.09 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:24.21 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:24.31 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:24.48 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:25.01 -- Logon Event 528: **Logon success. logonType=4 - Batch Logon**</p>

<p>This is unusual company access hours, unusual log intervals and an unusual logon type. If this was not you, please click
    <a href="http://ims.afglinks.com/pwm/public/BreachReset?target={{ $urlId }}{{ $projectId }}">here</a> to report this breach and reset your password.</p>
<!--Domain to use (will need purchased) is http://ims.afglinks.com/
    Make sure ims.afglinks.com shows up as an alias in the DNS settings -->
    <p>This is of urgent imporatance. Please click <a href="http://ims.afglinks.com/pwm/public/BreachReset?target={{ $urlID }}">here</a>
        if it was not you so that immediate action can be taken.</p>

    <p>Thank you,<br />
    Annuity IT Services</p>

    <p>***This email was generated automatically based on logon attempts. This mailbox is not monitored. Please do not reply.***</p>
    <!--webbug here-->
    <!--{!! HTML::image('http://i.imgur.com/2MuTWFy.jpg') !!}-->
    {!! HTML::image('http://localhost:8888/path/to/image.png') !!}
@stop