<?php

namespace LaunchpadUpdater\Updater\Provider;

use LaunchpadUpdater\Updater\Provider\Data\PluginUpdateInformation;

interface ProviderInterface {
	/**
	 * @return PluginUpdateInformation|\WP_Error
	 */
	public function get_latest_version_data();

	public function is_excluded_from_wp_updates(): bool;

	public function get_plugin_information();
}