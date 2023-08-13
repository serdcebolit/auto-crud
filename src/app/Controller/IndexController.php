<?php

namespace App\Controller;

use Lib\Application;
use Lib\Controller\BaseController;
use Lib\DataBase\DataManager;

class IndexController extends BaseController
{

	protected function getView(): string
	{
		return 'index';
	}

	protected function exec(): void
	{
		foreach (Application::getInstance()->getTableClasses() as $class)
		{
			/** @var DataManager $class */

			$url = str_replace('_', '-', $class::getTableName());

			$this->result[] = [
				'url' => '/' . $url . '/',
				'name' => $class::getDescription()
			];
		}
	}
}