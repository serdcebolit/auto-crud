<?php

namespace Lib\DataBase\Fields;

class ReferenceDto
{
	public function __construct(
		public string $currentFieldName,
		public string $referenceFieldName
	)
	{
	}
}