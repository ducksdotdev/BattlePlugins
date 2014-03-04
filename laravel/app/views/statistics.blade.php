@extends('layouts.master')
@section('content')
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2>BattlePlugins Statistics</h2>
				<p>Statistics update on a half-hourly basis. This is to ensure that the data we're displaying is as accurate as possible. Each graph is also cached every half hour in order to speed up the loading of this page. By hitting the refresh button for a graph you will only be clearing the cache, not updating the data.</p>
			</div>
		</div>
	</div>
</div>
<div class="content-section-b">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title"><i class="fa fa-bar-chart-o panel-icon"></i>Total Servers and Players<a href="/statistics/reload/getTotalServers"><i class="fa fa-refresh pull-right panel-icon"></i></a></div>
					</div>
					<div id="serversGraph" class="panel-body"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title"><i class="fa fa-bar-chart-o panel-icon"></i>Total Plugin Usage<a href="/statistics/reload/getPluginCount"><i class="fa fa-refresh pull-right panel-icon"></i></a></div>
					</div>
					<div class="panel-body" id="pluginsGraph"></div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title"><i class="fa fa-bar-chart-o panel-icon"></i>Authentication Modes<a href="/statistics/reload/getAuthMode"><i class="fa fa-refresh pull-right panel-icon"></i></a></div>
					</div>
					<div class="panel-body" id="authGraph"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('extraScripts')
<script src="/assets/js/highcharts.min.js"></script>
@if($dev && !Config::get('deploy.minify-development'))
<script src="/assets/js/charts.js"></script>
@else
<script src="/assets/js/charts.min.js"></script>
@endif
@stop