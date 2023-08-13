<?php

namespace Lib;

use function _\first;

class Request
{
	protected string $url = '';
	protected array $get = [];
	protected array $post = [];
	protected string $method = '';
	protected array $files = [];

	public function __construct()
	{
		$this->url = first(explode('?', $_SERVER['REQUEST_URI']));
		$this->get = $_GET;
		$this->post = $_POST;
		$this->files = $_FILES;
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function getGet(): array
	{
		return $this->get;
	}

	public function getPost(): array
	{
		return $this->post;
	}

	public function getFiles(): array
	{
		return $this->files;
	}

	public function getRequestMethod(): string
	{
		return $this->method;
	}
}