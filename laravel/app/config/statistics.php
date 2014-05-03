<?php

return array(
	// Where are statistics files store?
	'location' => '/home/battleplugins/stats',

	// What statistics are tracked?
	'tracked'    => array(
		// Bukkit Statistics
		// 'bServerName',
		'bVersion',
		'bOnlineMode',
		'bPlayersOnline',

		// System Statistics
		'osArch',
		'osName',
		'osVersion',
		'jVersion',
		'nCores'
	),

	// These are the names of the chart JSON methods
	'charts'     => array(
		'getTotalServers',
		'getPluginCount',
		'getAuthMode'
	),

	// Amount of items to cache before pushing to DB
	'max-cached' => 250,

	// How often (in minutes) stats are collected from a server
	'interval'   => 30
);