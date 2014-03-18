<div class="col-lg-12">
	<div class="row">
		<div class="panel panel-primary" id="addPluginPanel">
			<div class="panel-body">
				<div id="alert"></div>
				<div class="row">
					{{ Form::open(array('id'=>'addPluginForm','class'=>'ugly')) }}
					<div class="col-lg-4"><h1 id="pluginName"></h1></div>
					<div class="col-lg-7"><div class="form-group" id="inputGroup"><input type="text" class="form-control input-xl" placeholder="Plugin Slug" name="pluginSlug" id="pluginSlug" autocomplete="off" /></div></div>
					<div class="col-lg-1">
						<button type="submit" class="btn btn-primary btn-block" disabled>Add</button>
						<button type="reset" class="btn btn-warning btn-block">Cancel</button>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>