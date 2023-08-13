<?php

namespace App\Table;

use Lib\DataBase\DataManager;
use Lib\DataBase\Fields\IntegerField;
use Lib\DataBase\Fields\ReferenceDto;
use Lib\DataBase\Fields\ReferenceField;
use Lib\Enum\JoinTypes;

class OrderTable extends DataManager
{
	public static function getTableName(): string
	{
		return 'order';
	}

	public static function getDescription(): string
	{
		return 'Заказы';
	}

	/**
	 * @inheritDoc
	 */
	public static function getMap(): array
	{
		return [
			'ID' => (new IntegerField('ID'))
				->setTitle('ID'),
			'TOTAL_PRICE' => (new IntegerField('TOTAL_PRICE'))
				->setTitle('Сумма заказа'),
			'USER_ID' => (new IntegerField('USER_ID'))
				->setTitle('ID Пользователя')
				->setNeedToShow(false),
			'USER' => (new ReferenceField(
				'USER',
				UserTable::class,
				new ReferenceDto(
					'USER_ID',
					'ID'
				),
				JoinTypes::Inner
			))
				->setTitle('Пользователь')
				->setFieldsToSelect(['NAME', 'SECOND_NAME', 'LAST_NAME']),
			'PICK_POINT_ID' => (new IntegerField('PICK_POINT_ID'))
				->setTitle('Пункт выдачи')
				->setNeedToShow(false),
			'PICK_POINT' => (new ReferenceField(
				'PICK_POINT',
				PickPointTable::class,
				new ReferenceDto(
					'PICK_POINT_ID',
					'ID'
				),
				JoinTypes::Inner,
			))
				->setTitle('Пункт выдачи')
				->setFieldsToSelect(['ADDRESS']),
			'PRODUCT' => (new ReferenceField(
				'PRODUCT',
				ProductTable::class,
				new ReferenceDto(
					'ORDER_ID',
					'PRODUCT_ID'
				),
				JoinTypes::Inner
			))
				->setTitle('Товары')
				->setFieldsToSelect(['NAME', 'PRICE'])
				->setIntermediateTable('product_orders'),
		];
	}
}