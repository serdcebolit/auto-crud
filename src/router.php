<?php

use App\Controller;
use Lib\Dto\Router;
use Lib\Enum\RequestMethods;

$router = \Lib\Application::getInstance()->getRouter();

// Индексовая страница
$router->run(new Router(
	url: '/',
	controller: Controller\IndexController::class,
	requestMethod: RequestMethods::Get,
	params: [
		'title' => 'Главная',
	],
));