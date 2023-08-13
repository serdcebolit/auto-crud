<?php

namespace Lib;

use Lib\Controller\BaseController;
use Lib\Enum\RequestMethods;
use Lib\Exception\ControllerNotFoundException;
use Lib\Exception\ModelNotFoundException;

class Router
{
	/**
	 * @var Dto\Router[]
	 */
	protected array $routes = [];
	protected bool $routeFound = false;

	public function __construct()
	{
	}

	public function registerRoute(Dto\Router $data): void
	{
		$this->routes[] = $data;
	}

	/**
	 * Создаёт экземпляр контроллера для отображения страниц или сохранения информации
	 *
	 * @throws ControllerNotFoundException|ModelNotFoundException
	 */
	public function run(bool $needToShow404 = true): void
	{
		$request = Application::getInstance()->getRequest();

		foreach ($this->routes as $route)
		{
			if ($route->url === $request->getUrl() && $route->requestMethod->value == $request->getRequestMethod())
			{
				if (!class_exists($route->controller))
				{
					throw new ControllerNotFoundException("Контроллер $route->controller не найден");
				}

				if (isset($route->params['title']))
				{
					Application::getInstance()->setTitle($route->params['title']);
				}

				/** @var BaseController $ob */
				$controller = new $route->controller($route->params);

				ob_start();
				$controller->run();
				$result = ob_get_clean();

				if (!$route->isRest || !$route->requestMethod == RequestMethods::POST)
				{
					ViewManager::show('header');
					echo $result;
					ViewManager::show('footer');
				}
				else
				{
					echo $result;
				}

				$this->routeFound = true;
				break;
			}
		}

		if (!$this->routeFound && $needToShow404)
		{
			static::show404();
		}
	}

	public function redirect(string $url): never
	{
		ob_start();
		header("Location: $url");
		ob_end_flush();
		exit();
	}

	/**
	 * @throws ModelNotFoundException
	 */
	public static function showError(?\Throwable $exception = null, bool $needTitle = true): never
	{
		if ($needTitle)
		{
			Application::getInstance()->setTitle('');
		}

		ob_start();
		ViewManager::show('header', ['needTitle' => $needTitle]);
		ViewManager::show('error', [
			'exception' => $exception,
		]);
		ViewManager::show('footer');
		ob_end_flush();
		exit($exception?->getCode() ?? 1);
	}

	public static function show404(): void
	{
		\Lib\Application::getInstance()->setTitle('Страница не найдена');
		\Lib\ViewManager::show('header', ['needTitle' => false, 'needSiteName' => true]);
		\Lib\ViewManager::show('404');
		\Lib\ViewManager::show('footer');
	}
}