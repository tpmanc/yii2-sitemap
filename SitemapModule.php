<?php

namespace tpmanc\sitemap;

use Yii;

// TODO: вывести lat update в шаблоне
class SitemapModule extends \yii\base\Module
{
    public $controllerNamespace = 'tpmanc\sitemap\controllers';

    /**
     * @var array Array with required models
     */
    public $items = [];

    /**
     * @var string Save folder path
     */
    public $savePath = '';

    /**
     * @var string Site web adress
     */
    public $baseUrl;

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    private function registerTranslations()
    {
        Yii::$app->i18n->translations['sitemap/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/tpmanc/yii2-sitemap/messages',
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
