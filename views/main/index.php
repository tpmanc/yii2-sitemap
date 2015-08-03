<?php

use \backend\modules\sitemap\SitemapModule;
use yii\helpers\Url;
// TODO: сделать сообщение что все ок или ошибка
?>
<div class="sitemap-default-index">
    <h1><?= SitemapModule::t('Site Map Generator') ?></h1>

    <p>
        <?php foreach ($models as $model) { ?>
        <?php } ?>
    </p>
</div>
