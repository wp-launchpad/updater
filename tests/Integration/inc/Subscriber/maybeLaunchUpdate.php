<?php

namespace LaunchpadUpdater\Tests\Integration\inc\Subscriber;

use LaunchpadUpdater\Tests\Integration\TestCase;

/**
 * @covers \LaunchpadUpdater\Subscriber::maybe_launch_update
 * @group AdminOnly
 */
class Test_maybeLaunchUpdate extends TestCase {

    protected $prefix;
    protected $container;

    protected $config;


    public static function set_up_before_class() {
        parent::set_up_before_class();
        remove_action( 'admin_init', '_maybe_update_core' );
        remove_action( 'admin_init', '_maybe_update_plugins' );
        remove_action( 'admin_init', '_maybe_update_themes' );
        remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'add_suggested_content' ), 1 );
    }

    public function set_up() {
        parent::set_up();

        $this->container = apply_filters('testcontainer', null);
        $this->prefix = $this->container->get('prefix');

        // Suppress warnings from "Cannot modify header information - headers already sent by".
        $this->error_level = error_reporting();
        error_reporting( $this->error_level & ~E_WARNING );

        add_filter("pre_option_{$this->prefix}last_version", [$this, 'old_version']);
    }

    public function tear_down()
    {
        remove_filter("pre_option_{$this->prefix}last_version", [$this, 'old_version']);
        parent::tear_down();
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        $this->config = $config;
        do_action('admin_init');

        self::assertSame($expected['install'], did_action("{$this->prefix}first_install"));
        self::assertSame($expected['update'], did_action("{$this->prefix}update"));
    }

    public function old_version() {
        return $this->config['old_version'];
    }
}
