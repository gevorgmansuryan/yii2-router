<?php

namespace Gevman\Router;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\helpers\FileHelper;

/**
 * Class Module
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 */
class Module extends BaseModule implements BootstrapInterface
{
    public $routeFolder;

    public function bootstrap($app)
    {
        $router = new Router($app->urlManager);
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