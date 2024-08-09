<?php

namespace LaunchpadUpdater\Updater\Provider\WordPressOrg;

use LaunchpadUpdater\Updater\Provider\ProviderInterface;

class Provider implements ProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function get_latest_version_data() {
		return new \WP_Error('invalid', 'This method should not be called');
	}

	public function is_excluded_from_wp_updates(): bool {
		return false;
	}

	public function get_plugin_information() {
		return new \WP_Error('invalid', 'This method should not be called');
	}
}