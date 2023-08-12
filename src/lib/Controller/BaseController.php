<?php

namespace Lib\Controller;

use Exception;
use Lib\ViewManager;

abstract class BaseController
{
	protected array $result = [];

	public function __construct(
		protected array $params = []
	)
	{}

	protected abstract function getView(): string;
	protected abstract function exec(): void;

	/**
	 * @throws Exception
	 */
	public function run(): void
	{
		$this->exec();

		ViewManager::show($this->getView(), $this->result);
	}
}