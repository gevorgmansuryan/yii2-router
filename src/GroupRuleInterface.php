<?php

namespace Gevman\Router;

/**
 * Interface GroupRuleInterface
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 */
interface GroupRuleInterface
{
    /**
     * @param $routePrefix
     * @return GroupRuleInterface
     */
    public function routePrefix($routePrefix);

    /**
     * @param $middleware
     * @return GroupRuleInterface
     */
    public function middleware($middleware);

    /**
     * @param $domain
     * @return GroupRuleInterface
     */
    public function domain($domain);

    /**
     * @param $prefix
     * @return GroupRuleInterface
     */
    public function prefix($prefix);

    public function group(\Closure $routes);
}