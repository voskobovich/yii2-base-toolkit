<?php

namespace voskobovich\base\helpers;

use Yii;

/**
 * Class RouteHelper.
 */
class RouteHelper
{
    /**
     * @var string the route used to determine if a menu item is active or not.
     *             If not set, it will use the route of the current request.
     *
     * @see params
     * @see isItemActive()
     */
    public static $route;

    /**
     * @var array the parameters used to determine if a menu item is active or not.
     *            If not set, it will use `$_GET`.
     *
     * @see route
     * @see isItemActive()
     */
    public static $params;

    /**
     * @return void
     */
    public static function init(): void
    {
        if (self::$route === null && Yii::$app->controller !== null) {
            self::$route = Yii::$app->controller->getRoute();
        }
        if (self::$params === null) {
            self::$params = Yii::$app->request->getQueryParams();
        }
    }

    /**
     * Проверка роута на активность.
     *
     * @param array $route
     *
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public static function isActive($route): bool
    {
        if (is_array($route[0])) {
            foreach ($route as $item) {
                if (self::isItemActive(['url' => $item])) {
                    return true;
                }
            }

            return false;
        }

        return self::isItemActive(['url' => $route]);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     *
     * @param array $item the menu item to be checked
     *
     * @return bool whether the menu item is active
     * @throws \yii\base\InvalidParamException
     */
    protected static function isItemActive($item): bool
    {
        self::init();

        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = Yii::getAlias($item['url'][0]);
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }

            if (ltrim($route, '/') !== self::$route) {
                return false;
            }

            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset(self::$params[$name]) || self::$params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}
