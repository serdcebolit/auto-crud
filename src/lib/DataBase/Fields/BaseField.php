<?php

namespace Lib\DataBase\Fields;

abstract class BaseField
{
	protected string $name;
	protected string $dataType;

	protected string $title;

	/** @var null|callable */
	protected $validation = null;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	protected abstract function setDataType(): void;

	public function setTitle(string $title): self
	{
		$this->title = $title;
		return $this;
	}

	public function getValidation(): ?Callable
	{
		return $this->validation;
	}

	public function setValidation(callable $validation): self
	{
		$this->validation = $validation;
		return $this;
	}
}