<?php

namespace Lib\DataBase;

use Exception;
use Lib\Application;
use Lib\DataBase\ORM\Query;

abstract class DataManager
{
	protected static array $sqlQueries = [];

	public static function getTableName(): string
	{
		return '';
	}

	/**
	 * @return array
	 */
	public abstract static function getMap(): array;

	/**
	 * @return Query
	 * @throws Exception
	 */
	public static function query(): Query
	{
		return new Query(static::getTableName());
	}

	public static function getSqlQueries(): array
	{
		return static::$sqlQueries;
	}

	public abstract static function getAll(): array;

	/**
	 * @param $params
	 * @return int
	 * @throws \InvalidArgumentException
	 */
	public static function add($params, $table = ''): int
	{
		if (!$params)
		{
			throw new \InvalidArgumentException("Empty parameters");
		}

		if (!mb_strlen($table))
		{
			$table = static::getTableName();
		}

		$fields = [];

		$columns = array_filter(array_keys($params), function($itm) {
			return !(mb_strtolower($itm) == 'id');
		});

		$sql = "insert into `" . $table . "` (" . implode(', ', $columns) . ") values (";

		$lastItm = array_pop($columns);

		foreach ($params as $key => $itm)
		{
			if (!(mb_strtolower($key) == 'id'))
			{
				$hash = md5($itm);
				$fields[':' . $hash] = $itm;

				$sql .= ($key != $lastItm) ? ":$hash, " : ':' . $hash;
			}
		}

		$sql .= ")";

		$tempSql = $sql;
		foreach ($fields as $alias => $field)
		{
			$tempSql = str_replace($alias, $field, $tempSql);
		}
		static::$sqlQueries[] = $tempSql;

		$db = Application::getInstance()->getDatabase()->getConnection();

		$stmt = $db->prepare($sql);

		$stmt->execute($fields);

		return $db->lastInsertId();
	}

	/**
	 * @param $id
	 * @param $params
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public static function update($id, $params): bool
	{
		if (!intval($id) || !$params)
		{
			throw new \InvalidArgumentException("Empty parameters");
		}

		$sql = "update `" . static::getTableName() . "` set ";
		$prepare = [];

		$countSelect = count($params);
		$counter = 0;
		foreach ($params as $column => $value)
		{
			$counter++;
			$temp = static::getAlias($column);

			$prepare[$temp] = $value;

			$sql .= "$column = $temp";

			if ($counter != $countSelect)
			{
				$sql .= ', ';
			}
		}

		$sql .= " where id = :id";
		$prepare[":id"] = $id;

		$tempSql = $sql;
		foreach ($prepare as $alias => $field)
		{
			$tempSql = str_replace($alias, $field, $tempSql);
		}
		static::$sqlQueries[] = $tempSql;

		$ob = Application::getInstance()
			->getDatabase()
			->getConnection()
			->prepare($sql);

		return $ob->execute($prepare);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public static function delete($id): bool
	{
		if (!intval($id))
		{
			throw new \InvalidArgumentException("Empty parameters");
		}


		$sql = 'delete from `' . static::getTableName() . '` where ID = :id';


		$db = Application::getInstance()->getDatabase()->getConnection();

		$stmt = $db->prepare($sql);

		$tempSql = $sql;
		$alias = ':id';
		$field = $id;
		$tempSql = str_replace($alias, $field, $tempSql);
		static::$sqlQueries[] = $tempSql;

		return $stmt->execute([':id' => $id]);
	}

	protected static function getAlias(string $column): string
	{
		return ':' . str_replace('.', '_', $column);
	}
}