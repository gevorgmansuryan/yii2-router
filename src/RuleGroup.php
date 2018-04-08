<?php

namespace Gevman\Router;

use yii\base\BaseObject;

/**
 * Class RuleGroup
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 */
class RuleGroup extends BaseObject implements GroupRuleInterface
{
    /**
     * @var string
     */
    public $prefix;

    public $defaults = [];

    public $middleware = [];

    public $domain;

    public $routePrefix = '';

    public $callBack;

    /**
     * @param $prefix
     * @return GroupRuleInterface|mixed
     */
    public function routePrefix($prefix)
    {
        $this->routePrefix = $prefix;
        return $this;
    }

    public function middleware($middleware)
    {
        $this->middleware = is_array($middleware) ? $middleware : [$middleware];
        return $this;
    }

    public function domain($domain)
    {
        $this->domain = rtrim($domain, '/');
        return $this;
    }

    public function prefix($prefix)
    {
        $this->prefix = trim($prefix, '/');
        return $this;
    }

    public function defaults(array $defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    public function group(\Closure $routes)
    {
        $this->callBack = $routes;
        Router::addGroup($this);
    }
}
