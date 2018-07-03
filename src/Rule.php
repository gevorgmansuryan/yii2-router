<?php

namespace Gevman\Router;

use yii\base\BaseObject;
use RuntimeException;

/**
 * Class Rule
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 */
class Rule extends BaseObject implements RuleInterface
{
    public $pattern;
    public $route;
    public $defaults = [];
    public $alias;
    public $verbs = [];

    private $middleware;
    private $config;

    public function init()
    {
        if (!empty($this->verbs)) {
            foreach ($this->verbs as $verb) {
                if (!in_array($verb, Router::VERBS)) {
                    throw new RuntimeException(sprintf('Verb `%s` is not supported.', $verb));
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function defaults(array $defaults)
    {
        $this->defaults =  array_merge($this->defaults, $defaults);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function named($name)
    {
        $this->alias = $name;
        return $this;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function getConfig()
    {
        return array_merge($this->config, [
            'defaults' => $this->defaults
        ]);
    }

    public function make(array $groups = [])
    {
        $prefix = [];
        $suffix = [];
        $routePrefix = [];
        $domain = [];
        $middleware = [];
        foreach ($groups as $group) {
            $suffix[] = $group->suffix;
            $prefix[] = $group->prefix;
            $domain[] = $group->domain;
            $routePrefix[] = $group->routePrefix;
            $middleware = array_merge($middleware, $group->middleware);
            $this->defaults = array_merge($this->defaults, $group->defaults);
        }
        $prefix = implode('/', array_filter(array_merge($domain, $prefix, [$this->pattern])));
        $route = implode('/', array_filter(array_merge($routePrefix, [$this->route])));
        $this->middleware = array_filter($middleware);
        $this->config = [
            'pattern' => $prefix,
            'route' => '/' . $route,
            'verb' => $this->verbs,
            'suffix' => implode('', $suffix)
        ];

        return $this;
    }
}