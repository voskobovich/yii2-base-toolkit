<?php

namespace voskobovich\base\helpers;

use Yii;
use yii\web\Cookie;

/**
 * Class Cookies.
 */
class Cookies
{
    /**
     * Add cookie.
     *
     * @param array|Cookie $cookie
     * @throws \yii\base\InvalidCallException
     */
    public static function add($cookie): void
    {
        if (is_array($cookie)) {
            $cookie = new Cookie($cookie);
        }

        Yii::$app->response->cookies->add($cookie);
    }

    /**
     * Returns whether there is a cookie with the specified name.
     * Note that if a cookie is marked for deletion from browser, this method will return false.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function has($name): bool
    {
        return Yii::$app->request->cookies->has($name);
    }

    /**
     * Get cookie object.
     *
     * @param string $name
     *
     * @return Cookie
     */
    public static function get($name): \yii\web\Cookie
    {
        return Yii::$app->request->cookies->get($name);
    }

    /**
     * Get cookie value.
     *
     * @param string $name
     * @param null $defaultValue
     *
     * @return mixed
     */
    public static function getValue($name, $defaultValue = null)
    {
        return Yii::$app->request->cookies->getValue($name, $defaultValue);
    }

    /**
     * Get count cookies.
     *
     * @return int
     */
    public static function count(): int
    {
        return Yii::$app->request->cookies->getCount();
    }

    /**
     * Remove cookie by name.
     *
     * @param string $name
     * @param bool $removeFromBrowser
     * @throws \yii\base\InvalidCallException
     */
    public static function remove($name, $removeFromBrowser = true): void
    {
        Yii::$app->request->cookies->remove($name, $removeFromBrowser);
    }

    /**
     * Remove all cookies.
     * @throws \yii\base\InvalidCallException
     */
    public static function removeAll(): void
    {
        Yii::$app->request->cookies->removeAll();
    }

    /**
     * Get cookie as array.
     *
     * @return array
     */
    public static function toArray(): array
    {
        return Yii::$app->request->cookies->toArray();
    }

    /**
     * Set cookies from array.
     *
     * @param array $value
     */
    public static function fromArray(array $value): void
    {
        Yii::$app->request->cookies->fromArray($value);
    }
}
