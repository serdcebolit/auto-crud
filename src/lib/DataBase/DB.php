<?php

namespace Lib\DataBase;

use Exception;
use Lib\Application;
use Lib\Exception\DataBaseException;
use PDO;

class DB
{
	private ?PDO $link;
	private string $hostName;
	private string $userName;
	private string $password;
	private string $database;

	/**
	 * @throws DataBaseException
	 */
	public function __construct()
	{
		$envManager = Application::getInstance()->getEnvironmentManager();

		$this->hostName = $envManager->get('db-host') ?? '';
		$this->userName = $envManager->get('db-user') ?? '';
		$this->password = $envManager->get('db-password') ?? '';
		$this->database = $envManager->get('db-name') ?? '';

		if (!mb_strlen($this->hostName) || !mb_strlen($this->userName) || !mb_strlen($this->password) || !mb_strlen($this->database))
		{
			throw new DataBaseException('Не заданы параметры подключения к БД');
		}

		$this->connect();
	}

	/**
	 * Создаёт подключение к БД
	 *
	 * @return void
	 * @throws DataBaseException
	 */
	private function connect()
	{
		try
		{
			$this->link = new PDO(
				'mysql:dbname=' . $this->database . ';host=' . $this->hostName,
				$this->userName,
				$this->password
			);
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (\Throwable $e)
		{
			throw new DataBaseException('Ошибка подключения к БД: ' . $e->getMessage(), previous: $e);
		}
	}

	/**
	 * Вызываем объект PDO
	 *
	 * @return PDO|null
	 */
	public function getConnection(): ?PDO
	{
		return $this->link;
	}

	public function ifTableExists($tableName): bool
	{
		$sql = "SELECT IF(COUNT(*)>0, 1, 0) AS 'existence' ";
		$sql .= "FROM `information_schema`.`TABLES` ";
		$sql .= "WHERE 1 AND `TABLE_SCHEMA`='" . $this->database . "' AND `TABLE_NAME`='" . $tableName . "'";

		return $this->getConnection()->query($sql)->fetch()["existence"];
	}
}