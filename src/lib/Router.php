<?php

namespace Lib;

use Lib\Controller\BaseController;
use Lib\Enum\RequestMethods;
use Lib\Exception\ControllerNotFoundException;
use Lib\Exception\ModelNotFoundException;
use function _\first;

class Router
{
	protected string $url = '';
	protected array $get = [];
	protected array $post = [];
	protected string $method = '';
	protected array $files = [];

	public function __construct()
	{
		$this->url = first(explode('?', $_SERVER['REQUEST_URI']));
		$this->get = $_GET;
		$this->post = $_POST;
		$this->files = $_FILES;
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Создаёт экземпляр контроллера для отображения страниц или сохранения информации
	 *
	 * @throws ControllerNotFoundException
	 */
	public function run(Dto\Router $data): void
	{
		if ($data->url === $this->url && $data->requestMethod->value == $this->method)
		{
			if (!class_exists($data->controller))
			{
				throw new ControllerNotFoundException("Контроллер $data->controller не найден");
			}

			if (isset($data->params['title']))
			{
				Application::getInstance()->setTitle($data->params['title']);
			}

			/** @var BaseController $ob */
			$controller = new $data->controller($data->params);

			ob_start();
			$controller->run();
			$result = ob_get_clean();

			if (!$data->isRest || !$data->requestMethod == RequestMethods::Post)
			{
				ViewManager::show('header');
				echo $result;
				ViewManager::show('footer');
			}
			else
			{
				echo $result;
			}

			exit();
		}
	}

	public function getCurrentUrl(): string
	{
		return $this->url;
	}

	public function getGet(): array
	{
		return $this->get;
	}

	public function getPost(): array
	{
		return $this->post;
	}

	public function getFiles(): array
	{
		return $this->files;
	}

	public function redirect(string $url): never
	{
		header("Location: $url");
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
}