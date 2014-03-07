<?php

return array(
	// Path to the git folder (without trailing slash)
	// Use {branch} to specify a specific branch name
	'path-to-branch'       => '/home/battleplugins/{branch}/BattlePlugins',

	// Branch names
	'master-branch'        => 'master',
	'development-branch'   => 'dev',

	// Update composer when changes are made?
	'update-composer'      => true,

	// Minify master branch?
	'minify-master'        => true,

	// Minify development branch?
	'minify-development'   => false,

	// Path to compiler.jar
	'compiler'             => '/home/tools/compiler.jar',

	// Path to compiler-stylesheets.jar
	'compiler-stylesheets' => '/home/tools/closure-stylesheets.jar',

	// What files should we minify on deploy?
	// File paths should start from after path-to-branch. Do not include a leading slash.
	'files-to-minify'      => array(
		'laravel/public/assets/css/style.css',
		'laravel/public/assets/js/admin.js',
		'laravel/public/assets/js/scripts.js',
		'laravel/public/assets/js/charts.js'
	),

	// What commands should we run before branch specific commands?
	// Use {branch} to specify a specific branch name
	'pre-commands'         => array(
		'php laravel/artisan down',
		'git stash',
		'git pull origin {branch}'
	),

	// What commands should we run after branch specific commands?
	// Use {branch} to specify a specific branch name
	'post-commands'        => array(
		'php laravel/artisan up'
	));
