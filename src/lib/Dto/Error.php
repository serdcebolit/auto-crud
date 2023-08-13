<?php

namespace Lib\Dto;

use Lib\ErrorManager;

class Error
{
	public function __construct(
		public ?string $message = null,
		public ?string $code = null,
		public string $type = ErrorManager::TYPE_ERROR,
	)
	{
	}
}