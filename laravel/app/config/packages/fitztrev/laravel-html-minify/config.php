<?php

use BattleTools\Util\Deploy;

Log::info(Deploy::isDeveloperMode());

return array(

    // Turn on/off minification
    'enabled' => !Deploy::isDeveloperMode(),

    // If you are using a javascript framework that conflicts
    // with Blade's tags, you can change them here
    'blade' => array(
        'contentTags' => array('{{', '}}'),
        'escapedContentTags' => array('{{{', '}}}')
    )

);
