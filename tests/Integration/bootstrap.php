<?php

namespace WP_Rocket\Tests\Integration;

use LaunchpadCore\EventManagement\EventManager;
use LaunchpadCore\Plugin;
use LaunchpadUpdater\ServiceProvider;
use League\Container\Container;

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function() {

        $plugin = new Plugin(new Container(), new EventManager());
        $plugin->load([
            'prefix' => 'test',
            'version' => '3.16'
        ], [
            ServiceProvider::class,
        ]);
    }
);