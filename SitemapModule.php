<?php

namespace tpmanc\sitemap;

use Yii;
// TODO: вывести lat update в шаблоне
class SitemapModule extends \yii\base\Module
{
    public $controllerNamespace = 'tpmanc\sitemap\controllers';

    public $items = [];

    public $savePath = '';

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['sitemap/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/tpmanc/sitemap/messages',
            'fileMap' => [
                'sitemap/module' => 'module.php',
            ],
        ];
    }

    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('sitemap/module', $message, $params, $language);
    }
}
