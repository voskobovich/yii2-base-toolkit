<?php

namespace voskobovich\base\helpers;

use Yii;


/**
 * Class Flash
 * @package voskobovich\base\helpers
 */
class Flash
{
    /**
     * @param $key
     * @param bool $value
     * @param bool $removeAfterAccess
     * @return mixed
     */
    public static function add($key, $value = true, $removeAfterAccess = true)
    {
        Yii::$app->session->addFlash($key, $value, $removeAfterAccess);
    }

    /**
     * @param $key
     * @param bool $value
     * @param bool $removeAfterAccess
     * @return mixed
     */
    public static function set($key, $value = true, $removeAfterAccess = true)
    {
        Yii::$app->session->setFlash($key, $value, $removeAfterAccess);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function has($key)
    {
        return Yii::$app->session->hasFlash($key);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function hasAndEqual($key, $value)
    {
        return Yii::$app->session->hasFlash($key) && Yii::$app->session->getFlash($key) == $value;
    }

    /**
     * @param $key
     * @param null $defaultValue
     * @param bool $delete
     * @return mixed
     */
    public static function get($key, $defaultValue = null, $delete = false)
    {
        return Yii::$app->session->getFlash($key, $defaultValue, $delete);
    }
}