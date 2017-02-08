<p>Good Morning!</p>
<p>Did you know that {{ $company }} recently updated their health insurance policies? There have been recent updates to
    these policies that could impact your eligibility to receive 401(k) Matching, Health or Dental Benefits, and other services.</p>

<p>You can check <a href='{!! url("/account=$user->UniqueURLId-$campaign->Id/policy_changes") !!}'>here</a> to see how these changes may affect you.</p>

    <p>Thank you,<br />
        Nick Beatty, Benefit Consultant<br />
        Strategic Employee Benefits Service</p>
<img src='{!! url("/account=$user->UniqueURLId-$campaign->Id/emaillogo.png") !!}' />