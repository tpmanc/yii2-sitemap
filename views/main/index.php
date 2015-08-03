<?php

use tpmanc\sitemap\SitemapModule;
use yii\helpers\Html;
// TODO: сделать сообщение что все ок или ошибка
?>
<div class="sitemap-default-index">
    <h1><?= SitemapModule::t('Site Map Generator') ?></h1>

    <p>
        <h3><?= SitemapModule::t('Check item for exclude from sitemap') ?></h3>

        <?php foreach ($models as $model) { ?>
            <?php foreach ($model as $item) { ?>
                <label>
                    <?= $item->title ?>
                    <input type="checkbox" value="">
                </label>
                <br>
            <?php } ?>
        <?php } ?>
    </p>

    <div class="">
        <?= Html::submitButton(SitemapModule::t('Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <br>
    <div class="">
        <?= Html::a(SitemapModule::t('Generate'), ['/sitemap/main/generate'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>
