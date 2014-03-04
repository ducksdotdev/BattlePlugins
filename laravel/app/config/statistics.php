<?php

return array(
    // What statistics are tracked?
    'tracked' => array(
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

    // These keys will only be allowed to be modified by a server once.
    'limited-keys' => array(),

	// These are the names of the chart JSON methods
	'charts' => array(
		'getTotalServers',
		'getPluginCount',
		'getAuthMode'
	)
);