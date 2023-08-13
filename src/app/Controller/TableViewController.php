<?php

namespace App\Controller;

use Lib\Application;
use Lib\Controller\BaseController;
use Lib\DataBase\DataManager;
use Lib\Dto\Error;

class TableViewController extends BaseController
{

	protected function getView(): string
	{
		return 'table';
	}

	protected function exec(): void
	{
		$tableName = $this->params['class'];
		echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($tableName, true) . '</pre>';

		if (is_subclass_of($tableName, DataManager::class))
		{
			echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($tableName::getAll(), true) . '</pre>';
		}
		else
		{
			Application::getInstance()->getErrorManager()->addError(new Error('Неверный класс таблицы'));
		}
	}
}