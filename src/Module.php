<?php

namespace Gevman\Router;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\helpers\FileHelper;
use yii\web\UrlManager;

/**
 * Class Module
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 */
class Module extends BaseModule implements BootstrapInterface
{
    public $routeFolder;

    public function bootstrap($app)
    {
        /** @var UrlManager $urlManager */
        $urlManager = $app->urlManager;
        $urlManager->enableStrictParsing = true;
        $urlManager->enablePrettyUrl = true;
        $router = new Router($urlManager);
        $router->dispatch();
    }

    public function init()
    {
        $this->loadRouteFiles();
    }

    public function loadRouteFiles()
    {
        foreach (FileHelper::findFiles(Yii::getAlias($this->routeFolder)) as $file) {
            require_once $file;
        }
    }
}