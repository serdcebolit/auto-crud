<?php

session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';

try
{
	\Lib\Application::getInstance()->init();
} catch (Throwable $e)
{
	\Lib\Router::showError($e, false);
}

if (\Lib\Application::getInstance()->getEnvironmentManager()->get('debug') == 'true')
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL ^ E_DEPRECATED);
}

// Создаёт папку с файлами для сохранения
if (!file_exists(\Lib\Application::getInstance()->getRootDir() . '/files'))
{
	mkdir(\Lib\Application::getInstance()->getRootDir() . '/files');
}

try
{
	// Конфиги сайта
	require_once \Lib\Application::getInstance()->getRootDir() . '/configuration.php';
	// Подключаем роутер
	require_once \Lib\Application::getInstance()->getRootDir() . '/router.php';

	\Lib\Application::getInstance()->getRouter()->run();

} catch (Throwable $e)
{
	if (\Lib\Application::getInstance()->getEnvironmentManager()->get('debug') == 'true')
	{
		\Lib\Application::getInstance()->getRouter()->showError($e);
	}
	else
	{
		\Lib\Application::getInstance()->getRouter()->showError();
	}
}