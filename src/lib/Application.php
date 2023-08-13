<?php

namespace Lib;

use Lib\DataBase\DataManager;
use Lib\DataBase\DB;
use Lib\Dto\Menu;
use function _\find;
use function _\map;

class Application
{
	private static ?Application $instance = null;
	private ?EnvironmentManager $environmentManager;
	private ?DB $db;
	private ?Router $router;
	private ?Request $request;
	private ?ErrorManager $errorManager;
	private string $title = '';
	private array $menu = [];
	private string $rootDir;
	private string $siteName;
	private array $tableClasses = [];

	public function __construct()
	{
		$this->rootDir = $_SERVER['DOCUMENT_ROOT'];

		$this->parseTableClasses();
	}

	public function init(): void
	{
		$this->environmentManager = new EnvironmentManager();
		$this->db = new DB();
		$this->router = new Router();
		$this->request = new Request();
		$this->errorManager = new ErrorManager();
	}

	public static function getInstance(): ?Application
	{
		if (!self::$instance)
		{
			self::$instance = new Application();
		}

		return self::$instance;
	}

	protected function parseTableClasses(): void
	{
		$tableDir = $this->getRootDir() . '/app/Table';

		$this->tableClasses = array_filter(map(array_filter(scandir($tableDir),
			fn($item) => !in_array($item, ['.', '..'])),
			fn($item) => '\\App\\Table\\' . str_replace('.php', '', $item)),
			fn($item) => is_subclass_of($item, DataManager::class)
		);
	}

	public function getTableClasses(): array
	{
		return $this->tableClasses;
	}

	public function getCurrentTableClass(): ?string
	{
		return find($this->menu, fn(Menu $menu) => $menu->link === $this->getRequest()->getUrl())?->params['class'] ?? null;
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

	public function getRequest(): Request
	{
		return $this->request;
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

	public function addMenu(Menu $menu): void
	{
		$this->menu[] = $menu;
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

	public function getErrorManager(): ErrorManager
	{
		return $this->errorManager;
	}
}