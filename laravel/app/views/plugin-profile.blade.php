@extends('layouts.master')
@section('content')
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2>{{ $plugin->name }} <small>Created by <a href="/profile/{{ $author }}">{{ $author }}</a></small></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-11 col-offset-lg-1">
				<p>
					<h3>Download {{ $lastFile->name }} for Minecraft v{{ $lastFile->gameVersion }} <a href="{{ $lastFile->downloadUrl }}">here</a>.</h3>
				</p>
				<p>
					<a href="http://dev.bukkit.org/bukkit-plugins/{{ $lastBuild['bukkit'] }}">Bukkit Project Page <i class="fa fa-external-link"></i></a>
				</p>
				<p>
					Last Successful Build: <a href="{{ $lastBuild['ci']['url'] }}">{{ $lastBuild['ci']['build'] }}</a>
				</p>
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
						<div class="panel-title"><i class="fa fa-bar-chart-o panel-icon"></i>Version Statistics</div>
					</div>
					<div id="versionStatistics" data-plugin="{{ $plugin->name }}" class="panel-body"></div>
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