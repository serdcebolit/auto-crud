<?php

namespace Lib\DataBase;

use Exception;
use Lib\Application;
use Lib\DataBase\Fields\BaseField;
use Lib\DataBase\Fields\ReferenceField;
use Lib\DataBase\ORM\Query;
use Lib\Exception\DataBaseException;
use function _\difference;
use function _\groupBy;
use function _\map;

abstract class DataManager
{
	protected static array $sqlQueries = [];

	public static function getTableName(): string
	{
		return '';
	}
	public abstract static function getDescription(): string;

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
		$query = new Query(static::getTableName());

		foreach (static::getMap() as $field)
		{
			if ($field instanceof ReferenceField)
			{
				if (!is_subclass_of($field->getJoinTableClass(), DataManager::class))
				{
					throw new DataBaseException("Class {$field->getJoinTableClass()} is not instance of " . DataManager::class);
				}

				if ($field->getIntermediateTable())
				{
					$query->registerRuntimeField(
						$field->getIntermediateTable() . '_alias',
						[
							'data_class' => $field->getIntermediateTable(),
							'reference' => [
								'this' => 'ID',
								'ref' => $field->getReferenceFields()->currentFieldName,
							],
							'join_type' => $field->getJoinType()->value,
						]
					);

					$query->registerRuntimeField(
						$field->getName(),
						[
							'data_class' => $field->getJoinTableClass()::getTableName(),
							'reference' => [
								'this' => $field->getIntermediateTable() . '_alias.' . $field->getReferenceFields()->referenceFieldName,
								'ref' => 'ID',
							],
							'join_type' => $field->getJoinType()->value,
						]
					);
				}
				else
				{
					$query->registerRuntimeField(
						$field->getName(),
						[
							'data_class' => $field->getJoinTableClass()::getTableName(),
							'reference' => [
								'this' => $field->getReferenceFields()->currentFieldName,
								'ref' => $field->getReferenceFields()->referenceFieldName,
							],
							'join_type' => $field->getJoinType()->value,
						]
					);
				}
			}
		}

		return $query;
	}

	public static function getSqlQueries(): array
	{
		return static::$sqlQueries;
	}

	public static function getAll(): array
	{
		$query = static::query();
		$flatResult = [];
		$result = [];
		$refFields = [];

		foreach (static::getMap() as $field)
		{
			if ($field instanceof ReferenceField)
			{
				$refFields = [
					...$refFields,
					...map($field->getFieldsToSelect(), fn($item) => $field->getName() . '_' . $item),
				];
				foreach ($field->getFieldsToSelect() as $item)
				{
					$str = $field->getName() . '.' . $item;
					$query->addSelect($str, str_replace('.', '_', $str));
				}
			}
			else
			{
				/** @var $field BaseField */
				if ($field->getNeedToShow())
				{
					$str = static::getTableName() . '.' . $field->getName();
					$query->addSelect($str, str_replace('.', '_', $str));
				}
			}
		}

		$sqlResult = $query->addOrder(static::getTableName() . '.ID', 'ASC')
			->exec()
			->fetchAll();

		echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($refFields, true) . '</pre>';

		foreach ($sqlResult as $item)
		{
			$newItm = [];

			foreach ($item as $key => $value)
			{
				$newItm[str_replace(static::getTableName() . '_', '', $key)] = $value;
			}

			$flatResult[] = $newItm;
		}

		// объединяем записи по одинаковым знаениям, а разные значения собираем в массив

		return $flatResult;
	}

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