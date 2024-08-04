<?php

namespace LaunchpadUpdater\Updater\Provider;

use LaunchpadUpdater\Updater\Provider\Data\PluginInformation;

interface ProviderInterface {
	/**
	 * @return PluginInformation|\WP_Error
	 */
	public function get_latest_version_data();

	public function is_excluded_from_wp_updates(): bool;
}