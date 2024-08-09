<?php

namespace LaunchpadUpdater\Updater\Provider\Data;

class PluginInformation {
	protected $name = '';

	protected $slug = '';

	protected $author = '';

	protected $author_profile = '';

	protected $version = '';

	protected $tested = '';

	protected $requires = '';

	protected $requires_php = '';

	protected $download_link = '';

	protected $trunk = '';

	protected $last_updated = '';

	protected $sections = [];

	protected $banners = [];

	public function get_name(): string {
		return $this->name;
	}

	public function set_name( string $name ) {
		$this->name = $name;
	}

	public function get_slug(): string {
		return $this->slug;
	}

	public function set_slug( string $slug ) {
		$this->slug = $slug;
	}

	public function get_author(): string {
		return $this->author;
	}

	public function set_author( string $author ) {
		$this->author = $author;
	}

	public function get_author_profile(): string {
		return $this->author_profile;
	}

	public function set_author_profile( string $author_profile ) {
		$this->author_profile = $author_profile;
	}

	public function get_version(): string {
		return $this->version;
	}

	public function set_version( string $version ) {
		$this->version = $version;
	}

	public function get_tested(): string {
		return $this->tested;
	}

	public function set_tested( string $tested ) {
		$this->tested = $tested;
	}

	public function get_requires(): string {
		return $this->requires;
	}

	public function set_requires( string $requires ) {
		$this->requires = $requires;
	}

	public function get_requires_php(): string {
		return $this->requires_php;
	}

	public function set_requires_php( string $requires_php ) {
		$this->requires_php = $requires_php;
	}

	public function get_download_link(): string {
		return $this->download_link;
	}

	public function set_download_link( string $download_link ) {
		$this->download_link = $download_link;
	}

	public function get_trunk(): string {
		return $this->trunk;
	}

	public function set_trunk( string $trunk ) {
		$this->trunk = $trunk;
	}

	public function get_last_updated(): string {
		return $this->last_updated;
	}

	public function set_last_updated( string $last_updated ) {
		$this->last_updated = $last_updated;
	}

	public function get_sections(): array {
		return $this->sections;
	}

	public function set_sections( array $sections ) {
		$this->sections = $sections;
	}

	public function get_banners(): array {
		return $this->banners;
	}

	public function set_banners( array $banners ) {
		$this->banners = $banners;
	}
}