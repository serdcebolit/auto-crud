<?php

namespace Lib\Enum;

enum FieldTypes : string
{
	case Integer = 'integer';
	case String = 'string';
	case Boolean = 'boolean';
	case Date = 'date';
	case DateTime = 'datetime';
	case Reference = 'reference';
	case File = 'file';
}
