<?php

// INSERT: IROBO_BOILERPLATE //

class RoboFile extends \Robo\Tasks {
	use \iMi\RoboPack\LoadTasks;

	/**
	 * Initial project setup
	 */
	public function setup() {
		$config = $this->askSetup();
		$this->_writeEnvFile( $config );
		$this->_artisan( 'key:generate' );
	}

	/**
	 * Update the project from VCS and everything else
	 */
	public function update() {
		$this->taskGitStack()
		     ->pull()->run();
		$this->updateDependencies();
		$this->_artisan( 'migrate' );
		$this->cacheFlush();
	}

	/**
	 * Update dependencies only
	 */
	public function updateDependencies() {
		$this->taskComposerInstall()->run();
	}

	/**
	 * Replace the database with a clean one
	 */
	public function dbReplace() {
		$this->_artisan( 'migrate:refresh --seed' );
	}

	/**
	 * Flush all caches we know about
	 */
	public function cacheFlush() {
		$this->_artisanCacheFlush();
	}

	/**
	 * Update ide helpers - needs https://github.com/barryvdh/laravel-ide-helper
	 */
	public function updateIdeHelper() {
		$this->taskArtisanStack()->addUpdateIdeHelper()->run();
	}

}
