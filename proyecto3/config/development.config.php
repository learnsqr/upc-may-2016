<?php

return array(
    // Development time modules
    'modules' => array(
        'ZF\Apigility\Admin',
        'ZF\Configuration',
    ),
    'module_listener_options' => array(
        // Turn off caching
        'config_glob_paths' => array('config/autoload/{,*.}{global,local}-development.php'),
        'config_cache_enabled'     => false,
        'module_map_cache_enabled' => false,
    ),
);
