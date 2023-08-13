<?php
/* @var array $params */
$currentUrl = \Lib\Application::getInstance()->getRequest()->getUrl();
?>

<?php \Lib\ViewManager::show('alert');?>
<?php if (isset($params['items']) && $params['items']):?>
<table class="table table-striped mt-3">
	<thead>
	<tr>
		<?php foreach ($params['columns'] as $column): ?>
			<th scope="col"><?=$column?></th>
		<?php endforeach; ?>
		<th scope="col">Действия</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($params['items'] as $item): ?>
	<tr>
		<?php foreach ($item as $el): ?>
                <td><?=$el?></td>
		<?php endforeach;?>
		<td>
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="element_actions" data-bs-toggle="dropdown" aria-expanded="false">Выбрать действие</button>
                <ul class="dropdown-menu" aria-labelledby="element_actions">
                    <li><a href="<?=$currentUrl?>update/?id=<?=$item['ID']?>" class="dropdown-item">Изменить</a></li>
                    <li><a href="<?=$currentUrl?>delete/?id=<?=$item['ID']?>" class="dropdown-item confirm-delete">Удалить</a></li>
                </ul>
            </div>
		</td>
	</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php else:?>
    <div class="alert alert-warning alert-dismissible fade show mt-5" role="alert">
        Элементов не найдено
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<div class="pt-5 pb-5">
    <a href="<?=$currentUrl?>add/" class="btn btn-dark">Добавить запись</a>
</div>
