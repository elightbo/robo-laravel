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
		$this->executable = null;
		if (!$this->executable) {
			if (file_exists("artisan")) {
				$this->executable = "php artisan";
			}
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
