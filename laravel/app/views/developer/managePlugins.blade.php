@extends('layouts.master')
@section('content')
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<h2>Manage Plugins <small>({{ count($plugins) }})</small></h2>
				<p>Add, edit, or delete plugins from this page. You may only add Battle<em>Plugins</em> to this list. Plugins will go through an approval process before being added to the list. Adding a plugin to the website enables the following features:</p>
				<ul>
					<li><a href="http://ci.battleplugins.com/" target="_blank">Jenkins</a> tracking via the homepage and plugin list</li>
					<li>Statistics tracking for plugins using <a href="https://github.com/alkarinv/BattlePluginsAPI" target="_blank">BattlePluginsAPI</a></li>
					<li>Advertising of your plugin through BattlePlugins</li>
				</ul>
				<p><a href="http://wiki.battleplugins.com/w/index.php?title=BA_API_Tutorial">Check out our wiki page on how to create a BattleArena extension!</a></p>
			</div>
			<div class="col-lg-3 col-offset-lg-1">
				<h3>Manage</h3>
				<button class="btn btn-primary" id="addPlugin">Add Plugin</button>
			</div>
		</div>
	</div>
</div>
<div class="content-section-b">
	<div class="container" id="plugins">
		@foreach($plugins as $plugin)
		<div class="row" id="{{ $plugin->name }}">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-4"><h1><a href="/plugins/profile/{{ $plugin->name }}">{{ $plugin->name }}</a></h1><a href="http://dev.bukkit.org/bukkit-plugins/{{ $plugin->bukkit }}" target="_blank" class="text-right"><i class="fa fa-external-link pull-right"></i></a></div>
							<div class="col-lg-7"><input type="text" class="form-control input-xl" placeholder="Bukkit Slug" value="{{ $plugin->bukkit }}" disabled /></div>
							<div class="col-lg-1 text-right"><a href="#deletePlugin" class="btn btn-danger btn-sm" data-plugin="{{ $plugin->name }}"><i class="fa fa-times-circle fa-lg"></i></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@stop
