<p>Dear {{ $user->FirstName }} {{ $user->LastName }},</p>
<p>Your supervisor has reset your password for you. Please login using the password below. Don't forget to change
    your password after you log in. If your supervisor did not initiate this password change, please <a href="mailto:support@safephish.com">contact us</a>.</p>
<p>{{ $password }}</p>
<p>SafePhish will never send an email requesting information that will uniquely identify you. If you feel you have
    received a suspicious email, please forward it to our <a href="mailto:phishing@safephish.com">Phishing Response Team</a>.</p>

<br /><br />
<p>This message, including any attachments, may contain information
    which is confidential and privileged. Unless you are the addressee (or
    authorized to receive for the addressee), you may not read, use, copy
    or disclose to anyone the message, its attachments, or any information
    contained therein. If you have received the message in error, please
    advise the sender by reply e-mail and delete the message and any
    attachments.</p>