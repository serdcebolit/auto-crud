<?php

namespace Lib\Dto;

class Menu
{
	public function __construct(
		public string $title,
		public string $link,
		public array $params = [],
	)
	{
	}
}