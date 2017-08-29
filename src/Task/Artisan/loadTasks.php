<?php
namespace iMi\RoboLaravel\Task\Artisan;

trait loadTasks
{
    /**
     * @param string $pathToWpcli
     *
     * @return \iMi\RoboWpcli\Task\Wpcli\Stack
     */
    protected function taskArtisanStack()
    {
        return $this->task(Stack::class);
    }
}
