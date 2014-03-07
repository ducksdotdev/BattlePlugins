<?php

return array(
	// What statistics are tracked?
	'tracked'     => array(
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
	'charts'      => array(
		'getTotalServers',
		'getPluginCount',
		'getAuthMode'
	),

	// Amount of items to cache before pushing to DB
	'max-cached'  => 350,

	// Time, in minutes, to wait before pushing to DB. The DB must wait this time before checking the amount cached (above).
	'update-wait' => 2
);