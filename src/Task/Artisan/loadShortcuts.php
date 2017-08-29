<?php
namespace iMi\RoboLaravel\Task\Aristan;

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
