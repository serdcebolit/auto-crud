<?php

namespace App\Table;

use Lib\DataBase\DataManager;
use Lib\DataBase\Fields\IntegerField;
use Lib\DataBase\Fields\StringField;

class StockTable extends DataManager
{
	public static function getTableName(): string
	{
		return 'stock';
	}
	public static function getDescription(): string
	{
		return 'Склады';
	}

	/**
	 * @inheritDoc
	 */
	public static function getMap(): array
	{
		return [
			'ID' => (new IntegerField('ID'))
				->setTitle('ID'),
			'CITY' => (new StringField('CITY'))
				->setTitle('Город'),
			'ADDRESS' => (new StringField('ADDRESS'))
				->setTitle('Адрес'),
		];
	}
}