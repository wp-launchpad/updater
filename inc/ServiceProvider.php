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
        $this->register_service(\LaunchpadUpdater\Subscriber::class, function (Definition $definition) {
            $definition->addArgument($this->getContainer()->get('prefix'));
            $definition->addArgument($this->getContainer()->get('version'));
        });
    }
}
