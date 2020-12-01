<?php

use iMi\RoboPack\LoadTasks;
use Robo\Tasks;

// INSERT: IROBO_BOILERPLATE //

/**
 * @method _artisan(string $string)
 * @method taskComposerInstall()
 * @method _exec(string $string)
 * @method _writeEnvFile($config)
 * @method askSetup()
 * @method stopOnFail()
 */
class RoboFile extends Tasks
{
    use LoadTasks;

    /**
     * It is important to stop execution if there was an error
     */
    public function __construct()
    {
        $this->stopOnFail();
    }

    /**
     * Initial project setup
     */
    public function setup()
    {
        $config = $this->askSetup();
        $this->_writeEnvFile($config);
        $this->updateDependencies();
        $this->_artisan('key:generate');
        $this->update();
    }

    /**
     * Update the project from VCS and everything else
     *
     * @param array $opts
     */
    public function update($opts = ['runGitPull' => true, 'replaceAndSeed' => false])
    {
        $this->_exec('php artisan down || true');
        $this->controlQueueServiceIfExisting('stop');
        $this->_artisan('queue:restart');

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
        $this->controlQueueServiceIfExisting('start');
        $this->_artisan('up');
    }

    /**
     * Update dependencies only
     */
    public function updateDependencies()
    {
        $this->taskComposerInstall()->run();
        $this->updateFrontendDependencies();
    }

    /**
     * Update frontend dependencies only
     */
    public function updateFrontendDependencies()
    {
        $this->_exec('yarn --frozen-lockfile');
    }

    /**
     * Update assets
     */
    public function updateAssets()
    {
        $this->_exec('yarn run prod');
    }

    /**
     * Start frontend assets watcher
     */
    public function updateAssetsWatch()
    {
        $this->_exec('yarn run watch');
    }

    /**
     * Update Database only
     */
    public function dbUpdate()
    {
        $this->_artisan('migrate');
    }

    /**
     * Replace the database with a clean one
     */
    public function dbReplace()
    {
        $this->_artisan('migrate:refresh --seed');
    }

    /**
     * Flush all caches we know about
     */
    public function cacheFlush()
    {
        $this->_artisanCacheFlush();
    }

    /**
     * Update ide helpers - needs https://github.com/barryvdh/laravel-ide-helper
     */
    public function updateIdeHelper()
    {
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

    /**
     * Ability to start, stop and restart imi queue service if it exists.
     *
     * @param $command
     */
    private function controlQueueServiceIfExisting($command)
    {
        $path = explode('/', getcwd());
        $serviceName = $path[sizeof($path) - 2] . '-queue.service';
        if (file_exists('/etc/systemd/system/' . $serviceName)) {
            $this->_exec('sudo /bin/systemctl ' . $command . ' ' . $serviceName);
        }
    }
}
