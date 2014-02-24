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

    // Check if the request is coming from a MineCraft server
    'check-minecraft' => false
);