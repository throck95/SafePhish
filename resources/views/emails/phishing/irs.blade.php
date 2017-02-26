<img src='{!! url("/images/irs_logo.jpg") !!}' style="width: 150px; height: auto" />
<p>Mr. or Mrs. {{ $user->last_name }}:</p>
<p>We've noticed that we do not have all the information needed to be able to complete your tax return. We will need
    you to verify your account information before we can finalize your tax refund. Please visit our
    <a href=' {!! url("/account=$user->unique_url_id-$campaign->id/irs.gov") !!}'>site</a> and follow the instructions to verify
    your identity.</p>
<p>After following the instructions, it will take us approximately 7-14 days to process the new information.</p>
<p>Thank you for your assistance,<br />
    Internal Revenue Service<br />
    United States Department of Treasury</p>
<img src='{!! url("/account=$user->unique_url_id-$campaign->id/emaillogo.png") !!}' />