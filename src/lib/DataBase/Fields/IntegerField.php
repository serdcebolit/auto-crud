<?php

namespace Lib\DataBase\Fields;

use Lib\Enum\FieldTypes;

class IntegerField extends BaseField
{
	public function __construct(string $name)
	{
		parent::__construct($name);
		$this->setDataType();

		// default validation
		$this->setValidation(static function($value) {
			return is_numeric($value);
		});
	}

	protected function setDataType(): void
	{
		$this->dataType = FieldTypes::Integer->value;
	}
}