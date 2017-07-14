<?php

namespace voskobovich\base\helpers;

use Yii;

/**
 * Class Param.
 */
class Param
{
    /**
     * @param $key
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public static function get($key)
    {
        $params = Yii::$app->params;

        if (false === isset($params[$key])) {
            throw new \InvalidArgumentException("Key not found: {$key}");
        }

        return $params[$key];
    }
}
