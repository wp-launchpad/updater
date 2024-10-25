<?php
namespace LaunchpadUpdater;

use LaunchpadCore\EventManagement\SubscriberInterface;

class Subscriber implements SubscriberInterface {

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
     * Returns an array of events that this subscriber wants to listen to.
     *
     * The array key is the event name. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('hook_name' => 'method_name')
     *  * array('hook_name' => array('method_name', $priority))
     *  * array('hook_name' => array('method_name', $priority, $accepted_args))
     *  * array('hook_name' => array(array('method_name_1', $priority_1, $accepted_args_1)), array('method_name_2', $priority_2, $accepted_args_2)))
     *
     * @return array
     */
    public function get_subscribed_events() {
        return [
            'admin_init' => 'maybe_launch_update',
        ];
    }

    /**
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
