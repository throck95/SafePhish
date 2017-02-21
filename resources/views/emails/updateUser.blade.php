<p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
<p>Changes have been made to your account. If you did not initiate these changes, please <a href="mailto:support@safephish.org">contact us</a>.</p>
<div>
    <p><strong>Changes:</strong></p>
@foreach($changes as $change)
    <p>{{ $change }}</p>
@endforeach
</div>
<p>SafePhish will never send an email requesting information that will uniquely identify you. If you feel you have
    received a suspicious email, please forward it to our <a href="mailto:phishing@safephish.org">Phishing Response Team</a>.</p>

<br /><br />
<p>This message, including any attachments, may contain information
    which is confidential and privileged. Unless you are the addressee (or
    authorized to receive for the addressee), you may not read, use, copy
    or disclose to anyone the message, its attachments, or any information
    contained therein. If you have received the message in error, please
    advise the sender by reply e-mail and delete the message and any
    attachments.</p>