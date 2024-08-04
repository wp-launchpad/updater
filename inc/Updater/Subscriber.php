<?php

namespace LaunchpadUpdater\Updater;

use LaunchpadCore\Container\PrefixAware;
use LaunchpadCore\Container\PrefixAwareInterface;
use LaunchpadCore\Dispatcher\DispatcherAwareInterface;
use LaunchpadCore\Dispatcher\DispatcherAwareTrait;
use LaunchpadUpdater\Updater\Provider\ProviderInterface;

class Subscriber implements PrefixAwareInterface, DispatcherAwareInterface {

	use PrefixAware, DispatcherAwareTrait;

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	protected $cached_response = null;

	/**
	 * Current version of the plugin.
	 *
	 * @var string
	 */
	private $plugin_version;

	/**
	 * Full path to the plugin.
	 *
	 * @var string
	 */
	private $plugin_file;

	/**
	 * @param ProviderInterface $provider
	 * @param string $plugin_version
	 * @param string $plugin_file
	 */
	public function __construct( ProviderInterface $provider, string $plugin_version, string $plugin_file ) {
		$this->provider        = $provider;
		$this->plugin_version  = $plugin_version;
		$this->plugin_file     = $plugin_file;
	}


	/**
	 * @hook http_request_args
	 */
	public function maybe_exclude_from_wp_updates($request, $url) {
		if ( ! is_string( $url ) ) {
			return $request;
		}

		if ( ! preg_match( '@^https?://api.wordpress.org/plugins/update-check(/|\?|$)@', $url ) || empty( $request['body']['plugins'] ) ) {
			// Not a plugin update request. Stop immediately.
			return $request;
		}

		if ( ! $this->provider->is_excluded_from_wp_updates() ) {
			return $request;
		}

		/**
		 * Depending on the API version, the data can have several forms:
		 * - Can be serialized or JSON encoded,
		 * - Can be an object of arrays or an object of objects.
		 */
		$is_serialized = is_serialized( $request['body']['plugins'] );
		$basename      = plugin_basename( $this->plugin_file );
		$edited        = false;

		if ( $is_serialized ) {
			$plugins = maybe_unserialize( $request['body']['plugins'] );
		} else {
			$plugins = json_decode( $request['body']['plugins'] );
		}

		if ( ! empty( $plugins->plugins ) ) {
			if ( is_object( $plugins->plugins ) ) {
				if ( isset( $plugins->plugins->$basename ) ) {
					unset( $plugins->plugins->$basename );
					$edited = true;
				}
			} elseif ( is_array( $plugins->plugins ) ) {
				if ( isset( $plugins->plugins[ $basename ] ) ) {
					unset( $plugins->plugins[ $basename ] );
					$edited = true;
				}
			}
		}

		if ( ! empty( $plugins->active ) ) {
			$active_is_object = is_object( $plugins->active );

			if ( $active_is_object || is_array( $plugins->active ) ) {
				foreach ( $plugins->active as $key => $plugin_basename ) {
					if ( $plugin_basename !== $basename ) {
						continue;
					}
					if ( $active_is_object ) {
						unset( $plugins->active->$key );
					} else {
						unset( $plugins->active[ $key ] );
					}
					$edited = true;
					break;
				}
			}
		}

		if ( $edited ) {
			if ( $is_serialized ) {
				$request['body']['plugins'] = maybe_serialize( $plugins );
			} else {
				$request['body']['plugins'] = wp_json_encode( $plugins );
			}
		}

		return $request;
	}

	/**
	 * @hook pre_set_site_transient_update_plugins
	 */
	public function maybe_update_plugin_data($transient_value) {
		if ( defined( 'WP_INSTALLING' ) || ! $this->provider->is_excluded_from_wp_updates() ) {
			return $transient_value;
		}

		$remote_data = $this->fetch_latest_version();

		if ( is_wp_error( $remote_data ) ) {
			return $transient_value;
		}

		// Make sure the transient value is well formed.
		if ( ! is_object( $transient_value ) ) {
			$transient_value = new \stdClass();
		}

		if ( empty( $transient_value->response ) ) {
			$transient_value->response = [];
		}

		if ( empty( $transient_value->checked ) ) {
			$transient_value->checked = [];
		}

		// If a newer version is available, add the update.
		if ( version_compare( $this->plugin_version, $remote_data->get_new_version(), '<' ) ) {
			$transient_value->response[ $remote_data->get_plugin() ] = $remote_data;
		}

		$transient_value->checked[ $remote_data->get_plugin() ] = $this->plugin_version;

		return $transient_value;

		}

	/**
	 * @hook deleted_site_transient
	 */
		public function delete_update_data_cache($transient_name) {
			if ( 'update_plugins' !== $transient_name ) {
				return;
			}

			delete_site_transient( $this->get_cache_transient_name() );
		}

	/**
	 * @hook $prefixloaded
	 */
		public function maybe_force_check() {
			if ( ! is_string( filter_input( INPUT_GET, 'rocket_force_update' ) ) ) {
				return;
			}

			delete_site_transient( 'update_plugins' );
		}

		protected function fetch_latest_version() {

			if($this->cached_response) {
				return $this->cached_response;
			}

			$force_update = is_string( filter_input( INPUT_GET, 'rocket_force_update' ) );

			if ( ! $force_update ) {
				// No "force update": try to get the result from a transient.
				$response = get_site_transient( $this->get_cache_transient_name() );
				$this->cached_response = $response;

				if ( $response && is_object( $response ) ) {
					// Got something in cache.
					return $response;
				}
			}

			$response = $this->provider->get_latest_version_data();
			$this->cached_response = $response;

			$cache_duration = 12 * HOUR_IN_SECONDS;

			if ( is_wp_error( $response ) ) {
				$error_data = $response->get_error_data();

				if ( ! empty( $error_data['error_code'] ) ) {
					// `wp_remote_get()` returned an internal error ('error_code' contains a WP_Error code ).
					$cache_duration = HOUR_IN_SECONDS;
				} elseif ( ! empty( $error_data['http_code'] ) && $error_data['http_code'] >= 400 ) {
					// We got a 4xx or 5xx HTTP error.
					$cache_duration = 2 * HOUR_IN_SECONDS;
				}
			}

			set_site_transient( $this->get_cache_transient_name(), $response, $cache_duration );

			return $response;
		}

		public function get_cache_transient_name(): string {
			return $this->dispatcher->apply_string_filters($this->prefix . 'update_cache_transient_name', $this->prefix . 'update_data');
		}

}