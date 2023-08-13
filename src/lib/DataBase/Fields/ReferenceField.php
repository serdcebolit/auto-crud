<?php

namespace Lib\DataBase\Fields;

use Lib\Enum\FieldTypes;
use Lib\Enum\JoinTypes;

class ReferenceField extends BaseField
{
	protected ?string $intermediateTable = null;
	protected array $fieldsToSelect = [];

	public function __construct(
		string $name,
		protected string $dataClass,
		protected ReferenceDto $referenceFields,
		protected JoinTypes $joinTypes = JoinTypes::Inner,
	)
	{
		parent::__construct($name);

	}

	protected function setDataType(): void
	{
		$this->dataType = FieldTypes::Reference->value;
	}

	public function setIntermediateTable(string $intermediateTable): self
	{
		$this->intermediateTable = $intermediateTable;
		return $this;
	}

	public function getIntermediateTable(): ?string
	{
		return $this->intermediateTable;
	}

	public function getJoinTableClass(): string
	{
		return $this->dataClass;
	}

	public function getJoinType(): JoinTypes
	{
		return $this->joinTypes;
	}

	public function getReferenceFields(): ReferenceDto
	{
		return $this->referenceFields;
	}

	public function getFieldsToSelect(): array
	{
		return $this->fieldsToSelect;
	}

	public function setFieldsToSelect(array $fieldsToSelect): self
	{
		$this->fieldsToSelect = $fieldsToSelect;
		return $this;
	}
}