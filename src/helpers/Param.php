<?php

namespace voskobovich\base\helpers;

use Yii;


/**
 * Class Param
 * @package voskobovich\base\helpers
 */
class Param
{
    /**
     * Геттер параметров приложения
     * @param $need
     * @return mixed
     */
    public static function get($need)
    {
        $params = Yii::$app->params;

        if (!isset($params[$need])) {
            HttpError::the500("Key not found: {$need}");
        }

        return $params[$need];
    }
}