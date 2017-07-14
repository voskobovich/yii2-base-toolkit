<?php

namespace voskobovich\base\helpers;

use Yii;

/**
 * Class Flash.
 */
class Flash
{
    /**
     * @param $key
     * @param bool $value
     * @param bool $removeAfterAccess
     */
    public static function add($key, $value = true, $removeAfterAccess = true): void
    {
        Yii::$app->session->addFlash($key, $value, $removeAfterAccess);
    }

    /**
     * @param $key
     * @param bool $value
     * @param bool $removeAfterAccess
     */
    public static function set($key, $value = true, $removeAfterAccess = true): void
    {
        Yii::$app->session->setFlash($key, $value, $removeAfterAccess);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public static function has($key): bool
    {
        return Yii::$app->session->hasFlash($key);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public static function hasEqual($key, $value): bool
    {
        return Yii::$app->session->hasFlash($key) && Yii::$app->session->getFlash($key) === $value;
    }

    /**
     * @param $key
     * @param null $defaultValue
     * @param bool $delete
     *
     * @return mixed
     */
    public static function get($key, $defaultValue = null, $delete = false)
    {
        return Yii::$app->session->getFlash($key, $defaultValue, $delete);
    }
}
