<?php

namespace LaunchpadUpdater;

use LaunchpadCore\Container\AbstractServiceProvider;
use League\Container\Definition\Definition;
use function PHPUnit\Framework\stringContains;

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
			\LaunchpadUpdater\Updater\Subscriber::class,
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
            $definition->addArgument('prefix');
            $definition->addArgument('version');
        })->share();

		$this->register_service(\LaunchpadUpdater\Updater\Subscriber::class, function (Definition $definition) {
			$definition->addArgument('update_provider');
			$definition->addArgument('version');
			$definition->addArgument('plugin_file');
		})->share();
	}
}
