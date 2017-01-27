<header>
    <div id="headerBar"></div>
    <div id="logoBar">
        <a target="_blank" href="#">
            <img id="spHeadLogo" src="/images/logos/safephish_logo_v1.png" />
        </a>
    </div>
    @yield('header')
</header>
<div id="navBar">
    <div id="navButtonsDiv">
        <button class="navButton @yield('resultsClassDefault')" id="resultsNavButton">Results</button>
        <button class="navButton @yield('campaignsClassDefault')" id="campaignsNavButton">Campaigns</button>
        <button class="navButton @yield('templatesClassDefault')" id="templatesNavButton">Templates</button>
        <button class="navButton @yield('emailClassDefault')" id="emailNavButton">Email</button>
    </div>
    @if(\Session::get('authUser'))
        <a class="authenticationLink" target="_blank" href="#">MY ACCOUNT</a> <!-- create a my account page -->
        <a class="authenticationLink" href="/logout">LOGOUT</a>
    @else
        <a class="authenticationLink" href="/login">LOGIN</a>
    @endif
    <div id="navInfoDiv">
        <div class="templatesInfo">
            <img class='scalable' src="/images/thumbnails/templatePaper.png" /><h2><a href="/templates/show">View Templates</a></h2>
            <p>View all the templates currently accessible through the interface.</p>
        </div>
        <div class="templatesInfo">
            <img class='scalable' src="/images/thumbnails/createNewTemplate.png" /><h2><a href="/templates/create">New Template</a></h2>
            <p>Create a New Template to be used in the interface.</p>
        </div>
        <div class="campaignsInfo">
            <img class='scalable' src="/images/thumbnails/templatePaper.png" /><h2><a href="/campaigns/show">View Campaigns</a></h2>
            <p>View all the campaigns, both active and inactive.</p>
        </div>
        <div class="campaignsInfo">
            <img class='scalable' src="/images/thumbnails/createNewCampaign.png" /><h2><a href="/campaigns/create">New Campaign</a></h2>
            <p>Create a New Campaign to be used in managing phishing email scams.</p>
        </div>
        <div class="emailInfo">
            <img class='scalable' src="/images/thumbnails/createNewEmail.png" /><h2><a href="/email/generate">Start Campaign</a></h2>
            <p>Start a new phishing campaign or add to a current one.</p>
        </div>
        <div class="emailInfo">
            <img class='scalable' src="/images/thumbnails/emailSettings.png" /><h2><a href="/email/settings">Settings</a></h2>
            <p>Set default settings for your email environment.</p>
        </div>
        <div class="emailInfo">
            <img class='scalable' src="/images/thumbnails/newUser.png" /><h2><a href="/mailinglist/create/user">Create Mailing List User</a></h2>
            <p>Create a New Mailing List User to include in new campaigns.</p>
        </div>
        <div class="authInfo">
            <p>Please login to access information on this site.</p>
        </div>
    </div>
</div>