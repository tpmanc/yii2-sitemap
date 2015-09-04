<?php

namespace tpmanc\sitemap\controllers;

use Yii;
use yii\web\Controller;
use tpmanc\sitemap\SitemapModule;

class MainController extends Controller
{
    public function actionGenerate()
    {
        // echo Yii::$app->frontendUrlManager->createUrl(['/product/view', 'chpu' => 'adas']);die();

        $dom = new \DOMDocument('1.0', 'utf-8');
        $urlSet = $dom->createElement('urlset');
        $urlSet->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');

        $urlItems = $this->getUrlItems();

        foreach ($this->module->items as $i) {
            if (isset($i['where'])) {
                $models = $i['class']::find()->where($i['where'])->all();
            } else {
                $models = $i['class']::find()->all();
            }
            foreach ($models as $m) {
                $url = $dom->createElement('url');
                foreach ($urlItems as $item => $default) {
                    $elem = $dom->createElement($item);
                    if ($item === 'loc') {
                        $urlArr = $i['urlRule'];
                        foreach ($urlArr as $key => $part) {
                            if (isset($i['urlMethod'])) {
                                $part = str_replace('{{urlField}}', $m->{$i['urlMethod']}(), $part);
                            } else {
                                $part = str_replace('{{urlField}}', $m->{$i['urlField']}, $part);
                            }
                            $urlArr[$key] = $part;
                        }
                        $value = Yii::getAlias($this->module->baseUrl) . Yii::$app->frontendUrlManager->createUrl($urlArr);
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
