<?php

session_start();

// fatal error handler
function fatal_handler(): void
{
	$error = error_get_last();

	if ($error !== NULL)
	{
		throw new ErrorException($error["message"], $error["type"], 0, $error["file"], $error["line"]);
	}
}
//register_shutdown_function("fatal_handler"); //todo

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
	error_reporting(E_ALL);
}

// Создаёт папку с файлами для сохранения
if (!file_exists(\Lib\Application::getInstance()->getRootDir() . '/files'))
{
	mkdir(\Lib\Application::getInstance()->getRootDir() . '/files');
}

try
{
	require_once \Lib\Application::getInstance()->getRootDir() . '/configuration.php';
	// Подключаем роутер
	require_once \Lib\Application::getInstance()->getRootDir() . '/router.php';

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

// Если не нашёл нужную страницу, то показываем 404
\Lib\Application::getInstance()->setTitle('Страница не найдена');
\Lib\ViewManager::show('header', ['needTitle' => false, 'needSiteName' => true]);
\Lib\ViewManager::show('404');
\Lib\ViewManager::show('footer');
