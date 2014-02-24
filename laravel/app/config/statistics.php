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

    // These keys will only be allowed to be modified by a server once an hour.
    'limited-keys' => array(
        'bPlayersOnline'
    )
);