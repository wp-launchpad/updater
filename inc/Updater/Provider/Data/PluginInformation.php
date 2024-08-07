<?php

namespace LaunchpadUpdater\Updater\Provider\Data;

class PluginInformation {

	/**
	 * @var string
	 */
	protected $slug = '';

	/**
	 * @var string
	 */
	protected $plugin = '';

	/**
	 * @var string
	 */
	protected $new_version = '';

	/**
	 * @var string
	 */
	protected $url = '';

	/**
	 * @var string
	 */
	protected $package = '';

	/**
	 * @var string
	 */
	protected $stable_version = '';

	/**
	 * @var array
	 */
	protected $icons = [];

	public function get_slug(): string {
		return $this->slug;
	}

	public function set_slug( string $slug ): self {
		$this->slug = $slug;
		return $this;
	}

	public function get_plugin(): string {
		return $this->plugin;
	}

	public function set_plugin( string $plugin ): self {
		$this->plugin = $plugin;
		return $this;
	}

	public function get_new_version(): string {
		return $this->new_version;
	}

	public function set_new_version( string $new_version ): self {
		$this->new_version = $new_version;
		return $this;
	}

	public function get_url(): string {
		return $this->url;
	}

	public function set_url( string $url ): self {
		$this->url = $url;
		return $this;
	}

	public function get_package(): string {
		return $this->package;
	}

	public function set_package( string $package ): self {
		$this->package = $package;
		return $this;
	}

	public function get_stable_version(): string {
		return $this->stable_version;
	}

	public function set_stable_version( string $stable_version ): self {
		$this->stable_version = $stable_version;
		return $this;
	}

	public function get_icons(): array {
		return $this->icons;
	}

	public function set_icons( array $icons ): self {
		$this->icons = $icons;
		return $this;
	}

	public function dumps() {
		return [
			'slug' => $this->slug,
			'url' => $this->url,
			'plugin' => $this->plugin,
			'package' => $this->package,
			'new_version' => $this->new_version,
			'stable_version' => $this->stable_version,
			'icons' => $this->icons
		];
	}
}