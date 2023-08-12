<?php

use Lib\Application;
use Lib\Dto\Menu;

$app = Application::getInstance();

$app->setSiteName('Лаба ВолГУ');

// меню

$app->setMenu(
	[
		new Menu('Главная', '/'),
	]
);