<?php

namespace LaunchpadUpdater\Tests\Unit\inc\Subscriber;

use LaunchpadUpdater\Subscriber;


use LaunchpadUpdater\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadUpdater\Subscriber::get_subscribed_events
 */
class Test_getSubscribedEvents extends TestCase {

    /**
     * @var Subscriber
     */
    protected $subscriber;

    public function set_up() {
        parent::set_up();

        $this->subscriber = new Subscriber();
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->assertSame($expected, $this->subscriber->get_subscribed_events());

    }
}
