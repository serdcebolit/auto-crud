<?php /* @var array $params */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/bootstrap/bootstrap.min.css">
	<script src="/assets/js/jquery/jquery-3.6.0.js"></script>
	<script src="/assets/js/popper.min.js"></script>
	<script src="/assets/js/bootstrap/bootstrap.min.js"></script>
	<script src="/assets/js/script.js"></script>
	<title><?=!(isset($params['needTitle']) && !$params['needTitle']) ? \Lib\Application::getInstance()->getTitle() : ''?></title>
</head>
<body class="bg-light">
<header>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="/">
				<img src="/assets/images/learning-svgrepo-com.svg" width="25" height="25" class="me-3">
				<?=!(isset($params['needTitle']) && !$params['needTitle']) || (isset($params['needSiteName']) && $params['needSiteName']) ? \Lib\Application::getInstance()->getSiteName() : ''?>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<?php \Lib\ViewManager::show('menu');?>
			</div>
		</div>
	</nav>
</header>
<main class="flex-shrink-0">
	<div class="container pt-5">
		<h1 class="mt-5"><?=!(isset($params['needTitle']) && !$params['needTitle']) ? \Lib\Application::getInstance()->getTitle() : ''?></h1>