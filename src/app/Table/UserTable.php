<?php

namespace App\Table;

use Lib\DataBase\DataManager;
use Lib\DataBase\Fields\IntegerField;
use Lib\DataBase\Fields\StringField;

class UserTable extends DataManager
{
	public static function getTableName(): string
	{
		return 'user';
	}
	public static function getDescription(): string
	{
		return 'Покупатели';
	}

	/**
	 * @inheritDoc
	 */
	public static function getMap(): array
	{
		return [
			'ID' => (new IntegerField('ID'))
				->setTitle('ID'),
			'NAME' => (new StringField('NAME'))
				->setTitle('Имя'),
			'SECOND_NAME' => (new StringField('SECOND_NAME'))
				->setTitle('Фамилия'),
			'LAST_NAME' => (new StringField('LAST_NAME'))
				->setTitle('Отчество'),
		];
	}

}