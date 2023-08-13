<?php

use App\Controller;
use Lib\Application;
use Lib\Dto\Router;
use Lib\Enum\RequestMethods;
use Lib\Enum\TableViewActionTypes;

$router = Application::getInstance()->getRouter();

// Индексовая страница
$router->registerRoute(new Router(
	url: '/',
	controller: Controller\IndexController::class,
	requestMethod: RequestMethods::GET,
	params: [
		'title' => 'Главная',
	],
));

// CRUD
foreach (Application::getInstance()->getTableClasses() as $class)
{
	$url = '/' . str_replace('_', '-', $class::getTableName()) . '/';

	// Страница таблицы
	$router->registerRoute(new Router(
		url: $url,
		controller: Controller\TableViewController::class,
		requestMethod: RequestMethods::GET,
		params: [
			'title' => $class::getDescription(),
			'class' => $class,
		],
	));

	// Вывод страницы добавления
	$router->registerRoute(new Router(
		url: $url . '/add/',
		controller: Controller\TableViewController::class,
		requestMethod: RequestMethods::GET,
		params: [
			'title' => $class::getDescription(),
			'class' => $class,
			'action' => TableViewActionTypes::CREATE,
		],
	));

	// Обработка добавления
	$router->registerRoute(new Router(
		url: $url . '/add/',
		controller: Controller\TableViewController::class,
		requestMethod: RequestMethods::POST,
		params: [
			'title' => $class::getDescription(),
			'class' => $class,
			'action' => TableViewActionTypes::CREATE,
		],
	));

	// Вывод страницы редактирования
	$router->registerRoute(new Router(
		url: $url . '/edit/',
		controller: Controller\TableViewController::class,
		requestMethod: RequestMethods::GET,
		params: [
			'title' => $class::getDescription(),
			'class' => $class,
			'action' => TableViewActionTypes::EDIT,
		],
	));

	// Обработка редактирования
	$router->registerRoute(new Router(
		url: $url . '/edit/',
		controller: Controller\TableViewController::class,
		requestMethod: RequestMethods::POST,
		params: [
			'title' => $class::getDescription(),
			'class' => $class,
			'action' => TableViewActionTypes::EDIT,
		],
	));

	// Обработка удаления
	$router->registerRoute(new Router(
		url: $url . '/delete/',
		controller: Controller\TableViewController::class,
		requestMethod: RequestMethods::GET,
		params: [
			'title' => $class::getDescription(),
			'class' => $class,
			'action' => TableViewActionTypes::DELETE,
		],
	));
}