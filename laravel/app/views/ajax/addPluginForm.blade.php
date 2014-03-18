<div class="row">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div id="alert"></div>
			<div class="row">
				{{ Form::open(array('id'=>'addPluginForm')) }}
				<div class="col-lg-4"><h1 id="pluginName"></h1></div>
				<div class="col-lg-7"><input type="text" class="form-control input-xl" placeholder="Plugin Slug" /></div>
				<div class="col-lg-1"><button type="submit" class="btn btn-primary">Add</button></div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>