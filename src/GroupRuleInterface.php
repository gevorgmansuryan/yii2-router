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
     * @param array $middleware
     * @return GroupRuleInterface
     */
    public function middleware(array $middleware);

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

    /**
     * @param $suffix
     * @return GroupRuleInterface
     */
    public function suffix($suffix);

    /**
     * @param array $defaults
     * @return GroupRuleInterface
     */
    public function defaults(array $defaults);

    public function group(\Closure $routes);
}