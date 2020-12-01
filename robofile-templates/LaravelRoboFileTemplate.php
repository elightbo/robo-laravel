<?php

// INSERT: IROBO_BOILERPLATE //

class RoboFile extends \Robo\Tasks {
	use \iMi\RoboPack\LoadTasks;

    /**
     * It is important to stop execution if there was an error
     */
    public function __construct() {
        $this->stopOnFail();
    }

    /**
	 * Initial project setup
	 */
	public function setup() {
		$config = $this->askSetup();
		$this->_writeEnvFile( $config );
		$this->updateDependencies();
		$this->_artisan( 'key:generate' );
		$this->update();
	}

    /**
     * Update the project from VCS and everything else
     *
     * @param array $opts
     */
	public function update($opts = ['runGitPull' => true, 'replaceAndSeed' => false]) {
        $this->_exec('php artisan down || true');

        if (isset($opts['runGitPull']) && $opts['runGitPull']) {
            $this->taskGitStack()
                ->pull()->run();
        }

        $this->updateDependencies();

        if (isset($opts['replaceAndSeed']) && $opts['replaceAndSeed']) {
            $this->dbReplace();
        } else {
            $this->dbUpdate();
        }

        $this->updateAssets();
		$this->cacheFlush();
        $this->_artisan('up');
	}

	/**
	 * Update dependencies only
	 */
	public function updateDependencies() {
		$this->taskComposerInstall()->run();
		$this->_exec('yarn');
	}

    /**
     * Update assets
     */
    public function updateAssets()
    {
        $this->taskGulpRun()->run();
    }

    /**
     * Update Database only
     */
    public function dbUpdate() {
        $this->_artisan( 'migrate' );
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

    /**
     * Shows the laravel log
     */
    public function logTail()
    {
        $this->_exec('tail -f storage/logs/laravel.log');
    }

    /**
     * Seed the database
     */
    public function setupDev()
    {
        $this->_exec('php artisan db:seed --class=DatabaseSeeder');
    }
}
