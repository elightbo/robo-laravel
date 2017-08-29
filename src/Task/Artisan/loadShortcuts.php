<?php

namespace iMi\RoboLaravel\Task\Artisan;

use Robo\Task\File\Replace;
use Robo\Task\Filesystem\FilesystemStack;

trait loadShortcuts {
	/**
	 * @param string $url
	 *
	 * @return \Robo\Result
	 */
	protected function _artisan( $action ) {
		return $this->taskArtisanStack()->exec( $action )->run();
	}

	protected function _artisanCacheFlush() {
		return $this->taskArtisanStack()->addCacheFlush()->run();
	}

	protected function _writeEnvFile(
		$data,
		$mapVariablesToValues = [
			'dbName'     => 'DB_DATABASE',
			'dbHost'     => 'DB_HOST',
			'dbUser'     => 'DB_USERNAME',
			'dbPassword' => 'DB_PASSWORD',
		]
	) {
		$fileSystemTask = $this->task( FilesystemStack::class );
		$fileSystemTask->copy( '.env.example', '.env' )->run();
		foreach ( $mapVariablesToValues as $dataKey => $configKey ) {
			$value = isset( $data[ $dataKey ] ) ? $data[ $dataKey ] : '';
			$replaceTask = $this->task( Replace::class, '.env' );
			$replaceTask->regex( '/' . $configKey . '=.*/' )->to( $configKey . '=' . $value )->run();
		}
	}
}
