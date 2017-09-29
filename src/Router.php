<?php

namespace Gevman\Router;

use Yii;
use yii\base\Event;
use yii\web\Application;
use yii\web\UrlManager;
use yii\web\UrlRule;

/**
 * Class Router
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 */
class Router
{
    /** @var UrlManager */
    private $urlManager;
    private static $rules = [];
    private static $groups = [];

    const VERBS = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    public function __construct(UrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }

    private static function addGroupOptions(RuleGroup $group)
    {
        array_push(self::$groups, $group);
        return $group;
    }

    private static function deleteGroupOptions()
    {
        return array_pop(self::$groups);
    }

    public static function addRule(Rule $rule)
    {
        self::$rules[] = $rule->make(self::$groups);
    }

    public static function addGroup(RuleGroup $group)
    {
        self::addGroupOptions($group);
        ($group->callBack)();
        self::deleteGroupOptions();
    }

    public function dispatch()
    {
        Yii::$app->on(Application::EVENT_BEFORE_REQUEST, function (Event $event) {
            /** @var Application $app */
            $app = $event->sender;
            foreach (self::$rules as $route) {
                /** @var Rule $route */
                $config = $route->getConfig();
                $rule = new UrlRule($config);
                if ($request = $rule->parseRequest($this->urlManager, $app->request)) {
                    $params = ArrayHelper::merge($request, [$event]);
                    foreach ($route->getMiddleware() as $callBack) {
                        if (is_callable($callBack)) {
                            call_user_func_array($callBack, $params);
                        } else {
                            call_user_func_array([$callBack, 'handle'], $params);
                        }
                    }
                }
                $this->urlManager->addRules([$rule], false);
                if ($route->alias) {
                    Yii::setAlias($route->alias, $config['route']);
                }
            }
        });
    }
}