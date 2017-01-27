@extends('masters.basemaster')
@section('title')
    Show All Campaigns
@stop
@section('scripts')
    <script type="text/javascript" src="/js/showCampaigns.js"></script>
    <link rel="stylesheet" href="/css/jquery-ui.css" />
@stop
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="/css/showallstyles.css" />
@stop
@section('campaignsClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    <label>Filters: </label>
    <button id="activeShowButton">Active</button>
    <button id="inactiveShowButton">Inactive</button>
    <button id="showAllButton">All</button>
    <p>
        <label for="campaignNameSelect">Email Campaigns: </label>
        <select id='campaignNameSelect' name='campaignName' onchange="getCampaign(this)" size="{{ $campaignSize }}">
            @for ($i = 0; $i < $campaignSize; $i++)
                <option class="{{ $campaigns[$i]['CampaignStatus'] }}Campaign" value="{{ $campaigns[$i]['CampaignName'] }}">
                    {{ $campaigns[$i]['CampaignName'] }} ({{ $campaigns[$i]['CampaignStatus'] }})</option>
            @endfor
        </select>
    </p>
@stop
@section('footer')
    <p></p>
@stop