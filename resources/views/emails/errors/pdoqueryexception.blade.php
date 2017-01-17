<html>
<body>
<div class="rootContainer">
    <p>
    <h4>Trace</h4>
    <div>{{ $trace }}</div>
    </p>
    <p>
    <h4>Error Code</h4>
    <div>{{ $errorcode }}</div>
    </p>
    <p>
    <h4>Error Info</h4>
    <div>{{ $errorinfo }}</div>
    </p>
    <p>
    <h4>IP</h4>
    <div>{{ $ip }}</div>
    </p>
    <p>
    <h4>Exception Message</h4>
    <div>{{ $message }}</div>
    </p>
    <p>
    <h4>SQL Query</h4>
    <div>{{ $sql }}</div>
    </p>
    <p>
    <h4>Controller Parameters</h4>
    <div>{{ array_values($params) }}</div>
    </p>
</div>
</body>
</html>