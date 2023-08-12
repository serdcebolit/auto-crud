<?php

namespace Lib\Enum;

enum JoinTypes: string
{
	case Inner = 'inner';
	case Left = 'left';
	case Right = 'right';
}
