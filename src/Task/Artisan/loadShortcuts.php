<?php
namespace iMi\RoboLaravel\Task\Artisan;

trait loadShortcuts
{
    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _artisan($action)
    {
        return $this->taskArtisanStack()->exec($action)->run();
    }
}
