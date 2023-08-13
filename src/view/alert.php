<?php

use Lib\Application;
use Lib\ErrorManager;

$errors = Application::getInstance()->getErrorManager()->getErrors();
?>
<?php foreach ($errors as $error):?>
    <div class="alert <?=$error->type == ErrorManager::TYPE_ERROR ? 'alert-danger' : 'alert-warning'?> alert-dismissible fade show mt-3" role="alert">
		<?=$error->type == ErrorManager::TYPE_ERROR ? '<h4 class="alert-heading">Ошибка!</h4>' : ''?>
        <p><?=$error->message?></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endforeach;?>