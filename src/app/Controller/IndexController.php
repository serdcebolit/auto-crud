<?php

namespace App\Controller;

use Lib\Controller\BaseController;

class IndexController extends BaseController
{

	protected function getView(): string
	{
		return 'index';
	}

	protected function exec(): void
	{
		$this->result = [
			[
				'url' => '/clients/',
				'name' => 'Клиенты'
			],
			[
				'url' => '/loans/',
				'name' => 'Займы'
			]
		];
	}
}