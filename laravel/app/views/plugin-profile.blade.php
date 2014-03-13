@extends('layouts.master')
@section('content')
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2>{{ $plugin->name }} <small>Created by {{ $plugin->author }}</small></h2>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<a href="{{ $lastBuild['bukkit'] }}">Bukkit Project Page <i class="fa fa-external-link pull-right"></i></a><br />
					Last Successful Build: <a href="{{ $lastBuild['ci']['url'] }}">{{ $lastBuild['ci']['build'] }}</a><br />
				</div>
			</div>
		</div>
	</div>
</div>
<div class="content-section-b">
	<div class="container">

	</div>
</div>
@stop