<?php

use Lib\Application;
use Lib\Dto\Menu;

$app = Application::getInstance();

$app->setSiteName('Лаба ВолГУ');

// меню
$app->setMenu(
	[
		new Menu('Главная', '/'),
		...\_\map(Application::getInstance()->getTableClasses(),
			fn($class) => new Menu(
				$class::getDescription(),
				'/' . str_replace('_', '-', $class::getTableName()) . '/',
				['class' => $class]
			)
		)
	],
);