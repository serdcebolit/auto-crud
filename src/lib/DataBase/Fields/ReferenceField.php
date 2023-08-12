<?php

namespace Lib\DataBase\Fields;

use Lib\Enum\FieldTypes;
use Lib\Enum\JoinTypes;

class ReferenceField extends BaseField
{
	public function __construct(
		string $name,
		protected string $dataClass,
		protected ReferenceDto $referenceFields,
		protected JoinTypes $joinTypes = JoinTypes::Inner
	)
	{
		parent::__construct($name);

	}

	protected function setDataType(): void
	{
		$this->dataType = FieldTypes::Reference->value;
	}
}