<?php

namespace Lib\DataBase\Fields
{

	use lib\Enum\FieldTypes;

	class BooleanField extends BaseField
	{

		public function __construct(string $name)
		{
			parent::__construct($name);

			$this->setDataType();

			// default validation
			$this->setValidation(static function($value) {
				return is_bool($value);
			});
		}

		protected function setDataType(): void
		{
			$this->dataType = FieldTypes::Boolean->value;
		}
	}
}