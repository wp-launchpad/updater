<?php
namespace LaunchpadUpdater;

use LaunchpadCore\EventManagement\SubscriberInterface;

class Subscriber {

    /**
     * Prefix from the plugin.
     * @var string
     */
    protected $prefix;

    /**
     * Version from the plugin.
     * @var string
     */
    protected $version;

    /**
     * Instance from the class.
     *
     * @param string $prefix Prefix from the plugin.
     * @param string $version Version from the plugin.
     */
    public function __construct(string $prefix, string $version)
    {
        $this->prefix = $prefix;
        $this->version = $version;
    }

    /**
     * @hook admin_init
	 *
	 * Maybe launch the update.
     *
     * @return void
     */
    public function maybe_launch_update()
    {
        $last_version = get_option("{$this->prefix}last_version" , false);

        if(! $last_version) {
            /**
             * First install from the plugin.
             */
            do_action("{$this->prefix}first_install");
            return;
        }

        if($this->version === $last_version) {
            return;
        }

        /**
         * Update the plugin.
         * @param string $version Current version from the plugin.
         * @param string $last_version Last version from the plugin.
         */
        do_action("{$this->prefix}update", $this->version, $last_version);
    }
}
