<?php

namespace App\Table;

use Lib\DataBase\DataManager;
use Lib\DataBase\Fields\IntegerField;
use Lib\DataBase\Fields\StringField;

class PickPointTable extends DataManager
{
	public static function getTableName(): string
	{
		return 'pick_point';
	}

	public static function getDescription(): string
	{
		return 'Пункты выдачи';
	}

	/**
	 * @inheritDoc
	 */
	public static function getMap(): array
	{
		return [
			'ID' => (new IntegerField('ID'))
				->setTitle('ID'),
			'ADDRESS' => (new StringField('ADDRESS'))
				->setTitle('Адрес'),
		];
	}
}