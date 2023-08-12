<?php

namespace Lib\Dto;

use Lib\Enum\RequestMethods;

class Router
{
	public function __construct(
		public string $url,
		public string $controller,
		public RequestMethods $requestMethod,
		public bool $isRest = false,
		public array $params = []
	)
	{
	}
}