@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>BattlePlugins Statistics</h2>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Total Servers and Players</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="serversGraph"></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('extraScripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/highcharts/3.0.9/highcharts.js"></script>
@if($dev && !Config::get('deploy.minify-development'))
<script src="/assets/js/charts.js"></script>
@else
<script src="/assets/js/charts.min.js"></script>
@endif
@stop