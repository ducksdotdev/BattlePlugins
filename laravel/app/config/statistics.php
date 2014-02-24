<?php

return array(

    // What statistics are tracked?
    'tracked' => array(
        // Plugin Statistics
        'pName',
        'pVersion',

        // Bukkit Statistics
        'bServerName',
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
    'limited-keys' => array(

    ),

    // These keys can be updated as many times as needed
    'can-duplicate' => array(
        'pName',
        'pVersion'
    ),

    // Check if the request is coming from a MineCraft server
    'check-minecraft' => true
);