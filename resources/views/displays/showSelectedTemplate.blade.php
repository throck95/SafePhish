@extends('masters.basemaster')
@section('title')
    Show Template
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop
@section('stylesheets')

@stop
@section('bodyContent')
    <h3 style="text-align: center; font-weight: 300">{{ $publicName }}</h3>
    <div style="width: 70%; margin: auto">
        @foreach($templateText as $line)
            &lt; {{ $line }} &gt;
            <br />
        @endforeach
    </div>
    <br />
    <div style="text-align: center">
        <button onclick='window.location.href = "/templates/edit/{{ $fileName }}"' style="margin: auto">Edit Template</button>
    </div>
    <br />
@stop