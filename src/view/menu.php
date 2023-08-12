<?php /* @var \Lib\Dto\Menu $menu */ ?>
<ul class="navbar-nav me-auto mb-2 mb-md-0">
	<?php foreach (\Lib\Application::getInstance()->getMenu() as $menu): ?>
	<li class="nav-item">
		<a class="nav-link" href="<?=$menu->link?>"><?=$menu->title?></a>
	</li>
	<?php endforeach;?>
</ul>