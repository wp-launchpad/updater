<?php

namespace LaunchpadUpdater\Tests\Integration\inc\Subscriber;

use LaunchpadUpdater\Tests\Integration\TestCase;

/**
 * @covers \LaunchpadUpdater\Subscriber::get_subscribed_events
 */
class Test_getSubscribedEvents extends TestCase {

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {

    }
}
