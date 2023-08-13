<?php

namespace Lib;

use Lib\Dto\Error;
use function _\map;

class ErrorManager
{
	/** @var array<Error> */
	private array $previousErrors = [];
	/** @var array<Error> */
	private array $newErrors = [];

	public const TYPE_ERROR = 'error';
	public const TYPE_WARNING = 'warning';

	public function __construct()
	{
		$errors = $_SESSION['errors'];

		$this->previousErrors = map($errors, function ($error) {
			return $this->arrayToDto($error);
		});
	}

	public function __destruct()
	{
		$_SESSION['errors'] = map($this->newErrors, function ($error) {
			return $this->dtoToArray($error);
		});
	}

	public function arrayToDto($row): Error
	{
		return new Error(
			$row['message'],
			$row['code'],
			$row['type'],
		);
	}

	protected function dtoToArray($error): array
	{
		return [
			'message' => $error->message,
			'code' => $error->code,
			'type' => $error->type,
		];
	}

	/**
	 * @return array|Error[]
	 */
	public function getErrors(): array
	{
		return array_merge($this->previousErrors, $this->newErrors);
	}

	public function hasErrors(): bool
	{
		return count($this->previousErrors) || count($this->newErrors);
	}

	/**
	 * @param Error $error
	 * @return void
	 */
	public function addError(Error $error): void
	{
		$this->newErrors[] = $error;
	}
}