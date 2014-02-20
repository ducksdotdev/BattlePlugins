<?php

return array(

    'base_url'   => 'logviewer',
    'filters'    => array(
        'global' => array(),
        'view'   => array(),
        'delete' => array()
    ),
<<<<<<< Updated upstream
    'log_dirs' => array('app' => storage_path().'/logs'),
    'log_order' => 'desc',   // Change to 'desc' for the latest entries first
    'per_page' => 10,
    'view'     => 'logviewer::viewer',
=======
    'log_dirs'   => array('app' => storage_path().'/logs'),
    'log_order'  => 'asc', // Change to 'desc' for the latest entries first
    'per_page'   => 10,
    'view'       => 'logviewer::viewer',
    'p_view'     => 'pagination::slider'

>>>>>>> Stashed changes
);
