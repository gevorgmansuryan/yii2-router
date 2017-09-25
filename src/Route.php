<?php

namespace Gevman\Router;

use Closure;
use yii\helpers\ArrayHelper;

/**
 * Class Route
 * @author Gevorg Mansuryan <gevorgmansuryan@gmail.com>
 *
 * @method static RuleInterface any(string $from, string | string $to)
 * @method static RuleInterface get(string $from, string | string $to)
 * @method static RuleInterface head(string $from, string | string $to)
 * @method static RuleInterface post(string $from, string | string $to)
 * @method static RuleInterface put(string $from, string | string $to)
 * @method static RuleInterface patch(string $from, string | string $to)
 * @method static RuleInterface delete(string $from, string | string $to)
 * @method static RuleInterface options(string $from, string | string $to)
 */
class Route
{
    /**
     * @param $name
     * @param $arguments
     * @return RuleInterface
     */
    public static function __callStatic($name, $arguments)
    {
        $verb = strtoupper($name);
        $rule = new Rule([
            'pattern' => trim($arguments[0], '/'),
            'route' => $arguments[1],
            'verbs' => $verb != 'ANY' ? [$verb] : []
        ]);
        Router::addRule($rule);
        return $rule;
    }

    public static function catchAll($to)
    {
        $rule = new Rule([
            'pattern' => 'catchAll',
            'route' => $to,
            'verbs' => []
        ]);
        Router::addRule($rule);
    }

    public static function match(array $verbs, $from, $to)
    {
        $rule = new Rule([
            'pattern' => $from,
            'route' => $to,
            'verbs' => ArrayHelper::getColumn($verbs, function ($verb) {
                return strtoupper($verb);
            })
        ]);
        Router::addRule($rule);
        return $rule;
    }

    /**
     * @param $prefix
     * @return GroupRuleInterface
     */
    public static function routePrefix($prefix)
    {
        $group = new RuleGroup();
        $group->routePrefix($prefix);
        return $group;
    }

    /**
     * @param $middleware
     * @return GroupRuleInterface
     */
    public static function middleware($middleware)
    {
        $group = new RuleGroup();
        $group->middleware($middleware);
        return $group;
    }

    /**
     * @param $domain
     * @return GroupRuleInterface
     */
    public static function domain($domain)
    {
        $group = new RuleGroup();
        $group->domain($domain);
        return $group;
    }

    /**
     * @param $prefix
     * @return GroupRuleInterface
     */
    public static function prefix($prefix)
    {
        $group = new RuleGroup();
        $group->prefix($prefix);
        return $group;
    }
}