<?php

namespace LaunchpadUpdater\Tests\Integration\inc\Updater\Subscriber;

use LaunchpadUpdater\Tests\Integration\TestCase;

class Test_maybeExcludeFromWpUpdates extends TestCase {
	/**
	 * @dataProvider configTestData
	 */
	public function testShouldDoAsExpected($config, $expected) {
		$this->config = $config;
	}

	public function mock_() {

	}
}