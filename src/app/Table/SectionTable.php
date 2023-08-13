<?php

namespace App\Table;

use Lib\DataBase\DataManager;
use Lib\DataBase\Fields\IntegerField;
use Lib\DataBase\Fields\StringField;

class SectionTable extends DataManager
{
	public static function getTableName(): string
	{
		return 'product_section';
	}

	public static function getDescription(): string
	{
		return 'Категории товаров';
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
				->setTitle('Название'),
		];
	}
}