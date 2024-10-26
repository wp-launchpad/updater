<?php

namespace WP_Rocket\Tests\Integration;

use LaunchpadCore\EventManagement\EventManager;
use LaunchpadCore\EventManagement\Wrapper\SubscriberWrapper;
use LaunchpadCore\Plugin;
use LaunchpadDispatcher\Dispatcher;
use LaunchpadUpdater\ServiceProvider;
use League\Container\Container;

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function() {

		$prefix = 'test';
		$container = new Container();

        $plugin = new Plugin($container, new EventManager(), new SubscriberWrapper($prefix, $container), new Dispatcher());
        $plugin->load([
            'prefix' => $prefix,
            'version' => '3.16'
        ], [
            ServiceProvider::class,
        ]);
    }
);