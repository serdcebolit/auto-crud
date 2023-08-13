<?php

namespace App\Table;

use Lib\DataBase\DataManager;
use Lib\DataBase\Fields\IntegerField;
use Lib\DataBase\Fields\ReferenceDto;
use Lib\DataBase\Fields\ReferenceField;
use Lib\DataBase\Fields\StringField;
use Lib\Enum\JoinTypes;

class ProductTable extends DataManager
{
	public static function getTableName(): string
	{
		return 'product';
	}
	public static function getDescription(): string
	{
		return 'Товары';
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
			'SECTION_ID' => (new IntegerField('SECTION_ID'))
				->setTitle('Секция'),
			'SECTION' => (new ReferenceField(
				'SECTION',
				SectionTable::class,
				new ReferenceDto(
					'SECTION_ID',
					'ID'
				),
				JoinTypes::Inner
			))
				->setTitle('Секция'),
			'PRICE' => (new IntegerField('PRICE'))
				->setTitle('Цена'),
		];
	}
}