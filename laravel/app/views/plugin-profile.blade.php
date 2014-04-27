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
				@if($hasFiles)
				<p><h4><a href="{{ $lastFile->downloadUrl }}">Download {{ $lastFile->name }} for {{ $lastFile->gameVersion }}</a></h4></p>
				@endif
				<p>
					<a href="http://dev.bukkit.org/bukkit-plugins/{{ $lastBuild['bukkit'] }}">Bukkit Project Page <i class="fa fa-external-link"></i></a><br/>
					@if($lastBuild['ci']['build'] != 'None')
					Last Successful Build: <a href="{{ $lastBuild['ci']['url'] }}">{{ $lastBuild['ci']['build'] }}</a><br />
					<a href="http://ci.battleplugins.com/job/{{ $plugin->name }}/javadoc/">{{ $plugin->name }} Javadoc</a>
					@endif
				</p>
			</div>
		</div>
	</div>
</div>
<div class="content-section-b">
	<div class="container">
		@if($hasStats)
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title"><i class="fa fa-bar-chart-o panel-icon"></i>Version Statistics</div>
					</div>
					<div id="versionStatistics" data-plugin="{{ $plugin->name }}" class="panel-body">Loading...</div>
				</div>
			</div>
		</div>
		@endif
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