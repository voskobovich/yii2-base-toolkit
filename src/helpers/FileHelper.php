<?php

namespace voskobovich\base\helpers;

use yii\base\Exception;

/**
 * Class FileHelper.
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * Generate unique file name in directory.
     *
     * @param $path
     * @param string $extension
     *
     * @return string
     */
    public static function generateRandomName($path, $extension): string
    {
        if (strpos($extension, '.') !== 0) {
            $extension = '.' . $extension;
        }

        do {
            $name = md5(microtime() . random_int(0, 9999)) . $extension;
            $file = $path . DIRECTORY_SEPARATOR . $name;
        } while (file_exists($file));

        return $name;
    }

    /**
     * Download file from the link.
     *
     * @param string $url
     * @param string $path
     * @param string $name
     * @param string $extension
     *
     * @throws Exception
     *
     * @return array|bool
     */
    public static function saveFromUrl($url, $path, $name = null, $extension = 'png')
    {
        if (!self::createDirectory($path)) {
            throw new Exception("Directory not created \"$path\".");
        }

        $file = file_get_contents(urldecode($url));
        $extension = trim($extension, " \t\n\r\0\x0B.");

        if (null === $name) {
            $name = self::generateRandomName($path, $extension);
        } else {
            $name = $name . '.' . $extension;
        }

        if (file_put_contents($path . DIRECTORY_SEPARATOR . $name, $file)) {
            return [
                'name' => $name,
                'path' => $path,
            ];
        }

        return false;
    }
}
