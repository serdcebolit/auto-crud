<?php

namespace Lib\DataBase\Fields;

abstract class BaseField
{
	protected string $name;
	protected string $dataType;
	protected string $title;

	protected bool $needToShow = true;

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

	public function getName(): string
	{
		return $this->name;
	}

	public function setNeedToShow(bool $bool): self
	{
		$this->needToShow = $bool;
		return $this;
	}

	public function getNeedToShow(): bool
	{
		return $this->needToShow;
	}
}