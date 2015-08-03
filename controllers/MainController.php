<?php

namespace tpmanc\sitemap\controllers;

use yii\web\Controller;
use tpmanc\sitemap\SitemapModule;

class MainController extends Controller
{
    public function actionGenerate()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $urlSet = $dom->createElement('urlset');
        $urlSet->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');

        $urlItems = $this->getUrlItems();

        foreach ($this->module->items as $i) {
            $models = $i['class']::find()->all();
            foreach ($models as $m) {
                $url = $dom->createElement('url');
                foreach ($urlItems as $item => $default) {
                    $elem = $dom->createElement($item);
                    if ($item === 'loc') {
                        $value = $i['baseUrl'] . $m->{$i['urlField']};
                    } elseif (isset($i[$item])) {
                        $value = $i[$item];
                    } else {
                        $value = $default;
                    }
                    $elem->appendChild($dom->createTextNode($value));
                    $url->appendChild($elem);
                }
                $urlSet->appendChild($url);
            }
        }
        $dom->appendChild($urlSet);
        $xml = $dom->saveXML();
        $result = file_put_contents($this->module->savePath, $xml);

        if ($result === false) {
            \Yii::$app->getSession()->setFlash('error', SitemapModule::t('Error'));
        } else {
            \Yii::$app->getSession()->setFlash('success', SitemapModule::t('Complete'));
        }
        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        $items = $this->module->items;
        $models = [];
        foreach ($items as $item) {
            if (isset($item['enableExcluding']) && $item['enableExcluding'] === true) {
                $class = $item['class'];
                $models[$class::className()] = $class::find()->all();
            }
        }
        return $this->render('index', [
            'models' => $models,
        ]);
    }

    private function getUrlItems()
    {
        return [
            'loc' => '',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.4',
        ];
    }
}
