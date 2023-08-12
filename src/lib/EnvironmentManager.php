<?php

namespace Lib;

use Lib\Exception\SystemException;

class EnvironmentManager
{
	protected const EVN_FILE_PATH = '/.env';

	protected array $env = [];

	/**
	 * @throws SystemException
	 */
	public function __construct()
	{
		if (!file_exists(Application::getInstance()->getRootDir() . static::EVN_FILE_PATH))
		{
			throw new SystemException('Файл .env не найден');
		}

		$arEnv = explode("\n", file_get_contents(Application::getInstance()->getRootDir() . self::EVN_FILE_PATH));

		$arEnv = array_filter($arEnv);

		$env = [];

		foreach ($arEnv as $item)
		{
			$temp = explode('=', $item);

			if ($temp[1])
			{
				$env[trim($temp[0])] = trim($temp[1]);
			}
		}

		$this->env = $env;
	}

	public function get(string $key): ?string
	{
		return $this->env[$key] ?? null;
	}

	public function getAll(): array
	{
		return $this->env;
	}
}