<?php
namespace iMi\RoboLaravel\Task\Artisan;

use Robo\Task\CommandStack;

class Stack extends CommandStack
{
	/**
	 * @param null|string $pathToWpcli
	 *
	 * @throws \Robo\Exception\TaskException
	 */
	public function __construct()
	{
		$this->executable = 'artisan';
		if (!$this->executable) {
			$this->executable = $this->findExecutablePhar('artisan');
		}
		if (!$this->executable) {
			throw new TaskException(__CLASS__, "Artisan not found");
		}
	}

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo("Running Artisan commands...");
        return parent::run();
    }
}
