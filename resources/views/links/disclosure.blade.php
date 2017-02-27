@extends('masters.basemaster')
@section('title')
    Uh-Oh! This was a Phish!
@stop
@section('bodyContent')
<div>
    <p>Uh-oh! This was a phishing email. Your company, {{ $company }}, wants to help you learn how to identify phishing emails and deal with them.</p>
    <p>Phishing is becoming a much larger problem every day. Here's some tips that you can use to help you identify a phish:</p>
    <ol>
        <li>Do you know the sender? If not, it's likely a phish.</li>
        <li>Is the email asking for information? If so, it's likely a phish.</li>
        <li>Does the email contain numerous links? If so, it's likely a phish.</li>
    </ol>
    <p>In general, trust your instincts. Common sense is your best ally when dealing with phishing scams.</p>
    <iframe width="600" height="338" src="{{ $tipsVideoUrl }}" frameborder="0" allowfullscreen></iframe>
</div>
@stop