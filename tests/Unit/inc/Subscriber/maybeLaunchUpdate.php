<?php

namespace LaunchpadUpdater\Tests\Unit\inc\Subscriber;

use LaunchpadUpdater\Subscriber;


use LaunchpadUpdater\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadUpdater\Subscriber::maybe_launch_update
 */
class Test_maybeLaunchUpdate extends TestCase {

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
    public function testShouldDoAsExpected( $config )
    {
        $this->subscriber->maybe_launch_update();

    }
}
