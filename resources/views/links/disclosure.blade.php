<html>
<head>
    <title>Uh-Oh! This was a Phish!</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/copyright.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/css/basicstyles.css" />
    <link rel="stylesheet" type="text/css" href="/css/disclosure.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
<body>
<div class="rootContainer">
    <header>
        <div id="headerBar"></div>
        <div id="logoBar">
            <a href="/">
                <img id="spHeadLogo" src="/images/logos/safephish_logo.png" />
            </a>
        </div>
    </header>
    <div>
        <p>Uh-oh! This was a phishing email. Your company, {{ $company }}, wants to help you learn how to identify phishing emails and deal with them.</p>
        <p>Phishing is becoming a much larger problem every day. Here's some tips that you can use to help you identify a phish:</p>
        <ol>
            <li>Do you know the sender? If not, it's likely a phish.</li>
            <li>Is the email asking for information? If so, it's likely a phish.</li>
            <li>Does the email contain numerous links? If so, it's likely a phish.</li>
        </ol><br />
        <p>In general, trust your instincts. Common sense is your best ally when dealing with phishing scams.</p>
        <iframe width="600" height="338" src="{{ $tipsVideoUrl }}" frameborder="0" allowfullscreen></iframe>
        <br /><br />
    </div>
</div>
<footer>
    <div id="copyright" style="width: 50%; float:left"></div>
    <p style="float:right"><a href="#support">Contact Us</a></p>
</footer>
</body>
</html>