<?php

namespace Lib;

use Lib\DataBase\DB;

class Application
{
	private static ?Application $instance = null;
	private ?EnvironmentManager $environmentManager;
	private ?DB $db;
	private ?Router $router;
	private string $title;
	private array $menu = [];
	private string $rootDir;
	private string $siteName;

	public function __construct()
	{
		$this->rootDir = $_SERVER['DOCUMENT_ROOT'];
	}

	public function init(): void
	{
		$this->environmentManager = new EnvironmentManager();
		$this->db = new DB();
		$this->router = new Router();
	}

	public static function getInstance(): ?Application
	{
		if (!self::$instance)
		{
			self::$instance = new Application();
		}

		return self::$instance;
	}

	public function getRouter(): Router
	{
		return $this->router;
	}

	public function getEnvironmentManager(): EnvironmentManager
	{
		return $this->environmentManager;
	}

	public function getDatabase(): DB
	{
		return $this->db;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getMenu(): array
	{
		return $this->menu;
	}

	public function setMenu(array $menu): void
	{
		$this->menu = $menu;
	}

	public function getRootDir(): string
	{
		return $this->rootDir;
	}

	public function getSiteName(): string
	{
		return $this->siteName;
	}

	public function setSiteName(string $siteName): void
	{
		$this->siteName = $siteName;
	}
}