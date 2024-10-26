<?php

namespace LaunchpadUpdater;

use LaunchpadCore\Container\AbstractServiceProvider;
use League\Container\Definition\Definition;

/**
 * Service provider.
 */
class ServiceProvider extends AbstractServiceProvider
{

    /**
     * Return IDs from common subscribers.
     *
     * @return string[]
     */
    public function get_admin_subscribers(): array {
        return [
            \LaunchpadUpdater\Subscriber::class,
        ];
    }

    /**
     * Registers items with the container
     *
     * @return void
     */
    public function define()
    {
        $this->register_admin_subscriber(\LaunchpadUpdater\Subscriber::class)->set_definition(function (Definition $definition) {
			$definition->addArgument('prefix');
			$definition->addArgument('version');
		});
    }
}
