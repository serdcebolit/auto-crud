<?php

namespace Lib;

use Lib\Exception\ModelNotFoundException;

class ViewManager
{
	protected const VIEW_DIR = '/view/';

	/**
	 * @throws ModelNotFoundException
	 */
	public static function show(string $viewName, array $params = []): void
	{
		$pathToModel = Application::getInstance()->getRootDir() . self::VIEW_DIR . $viewName . '.php';

		if (!file_exists($pathToModel))
		{
			throw new ModelNotFoundException("Модель $viewName не найдена");
		}

		include $pathToModel;
	}
}