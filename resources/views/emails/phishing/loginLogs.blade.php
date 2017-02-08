<p>Mr. or Mrs. {{ $user->LastName }}: </p>
<p>There have been numerous login attempts to your corporate account.</p>

<p>{{ \Carbon\Carbon::now()->toDateTimeString() }} -- Logon Event 529: **Logon failure. Bad Password.**<br />
    {{ \Carbon\Carbon::now()->toDateTimeString() }} -- Logon Event 529: **Logon failure. Bad Password.**<br />
    {{ \Carbon\Carbon::now()->toDateTimeString() }} -- Logon Event 529: **Logon failure. Bad Password.**<br />
    {{ \Carbon\Carbon::now()->toDateTimeString() }} -- Logon Event 529: **Logon failure. Bad Password.**<br />
    {{ \Carbon\Carbon::now()->toDateTimeString() }} -- Logon Event 528: **Logon success. logonType=4 - Batch Logon**</p>

<p>This is an unusual access time for you, an unusually fast login interval, and a login type rarely used. If this was not you, please
    <a href='{!! url("/account=$user->UniqueURLId-$campaign->Id/breach/password_reset") !!}'>reset your password</a> and
    <a href='{!! url("/account=$user->UniqueURLId-$campaign->Id/breach/contact_us") !!}'>contact us</a> immediately.</p>

<p>***This email was generated automatically based on logon attempts. This mailbox is not monitored. Please do not reply.***</p>
<img src='{!! url("/account=$user->UniqueURLId-$campaign->Id/emaillogo.png") !!}' />