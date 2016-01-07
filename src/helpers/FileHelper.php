<?php

namespace voskobovich\base\helpers;


/**
 * Class FileHelper
 * @package voskobovich\base\helpers
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * Генерация уникального имени файла в директории
     * @param $path
     * @param string $extension
     * @return string
     */
    public static function getRandomFileName($path, $extension)
    {
        if (strpos($extension, '.') !== 0) {
            $extension = '.' . $extension;
        }

        do {
            $name = md5(microtime() . rand(0, 9999)) . $extension;
            $file = $path . DIRECTORY_SEPARATOR . $name;
        } while (file_exists($file));

        return $name;
    }
}