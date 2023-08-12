<?php
/* @var array $params */
$exception = $params['exception'];
?>

<?php if ($exception instanceof Throwable):?>
<div class="alert alert-danger mt-5" role="alert">
	<h3 class="alert-heading"><?='Поймано исключение: ' . get_class($exception)?></h3>
    <hr>
    <h5>Собщение:</h5>
    <p><?=$exception->getMessage()?></p>
    <hr>
    <h5>Файл и строка:</h5>
	<p><?=$exception->getFile() . ':' . $exception->getLine()?></p>
	<hr>
    <h5>Стектрейс:</h5>
	<pre class="mb-0"><?=$exception->getTraceAsString()?></pre>
</div>
<?php else:?>
<div class="alert alert-danger mt-5" role="alert">
	<h3 class="alert-heading">Ошибка</h3>
    <p>Для просмотра включите дебаг</p>
</div>
<?php endif;?>
