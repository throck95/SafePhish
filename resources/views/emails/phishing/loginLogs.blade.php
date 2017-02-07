<p>Mr. or Mrs. {{ $user->LastName }}: </p>
<p>There have been numerous login attempts to your corporate account.</p>

<p>2016-05-25T01:37:24.09 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:24.21 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:24.31 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:24.48 -- Logon Event 529: **Logon failure. Bad Password.**<br />
    2016-05-25T01:37:25.01 -- Logon Event 528: **Logon success. logonType=4 - Batch Logon**</p>

<p>This is an unusual access time for you, an unusually fast login interval, and a login type rarely used. If this was not you, please
    <a href="/account={{ $user->UniqueURLId }}-{{ $campaign->Id }}/breach/password_reset">reset your password</a> and
    <a href="/account={{ $user->UniqueURLId }}-{{ $campaign->Id }}/breach/contact_us">contact us</a> immediately.</p>

<p>***This email was generated automatically based on logon attempts. This mailbox is not monitored. Please do not reply.***</p>
<img src="/account={{ $user->UniqueURLId }}-{{ $campaign->Id }}/logo.gif" />