<?php

namespace voskobovich\baseToolkit\helpers;

use Yii;
use yii\base\Object;


/**
 * Class AlertHelper
 * @package voskobovich\baseToolkit\helpers
 */
class AlertHelper extends Object
{
    /**
     * Add success message
     * @param $body
     */
    public static function success($body)
    {
        if (!empty(Yii::$app->session)) {
            Yii::$app->session->setFlash('success', $body);
        }
    }

    /**
     * Сеттер флеш сообения - Ошибка
     * @param $body
     */
    public static function error($body)
    {
        if (!empty(Yii::$app->session)) {
            Yii::$app->session->setFlash('danger', $body);
        }
    }

    /**
     * Сеттер флеш сообения - Информация
     * @param $body
     */
    public static function info($body)
    {
        if (!empty(Yii::$app->session)) {
            Yii::$app->session->setFlash('info', $body);
        }
    }

    /**
     * Сеттер флеш сообения - Предупреждение
     * @param $body
     */
    public static function warning($body)
    {
        if (!empty(Yii::$app->session)) {
            Yii::$app->session->setFlash('warning', $body);
        }
    }

    /**
     * Геттер флеш сообщений
     * @return mixed
     */
    public static function show()
    {
        $flashes = Yii::$app->session->getAllFlashes();

        foreach ($flashes as $type => $body) {
            switch ($type) {
                case 'success':
                    echo '<div class="alert alert-success alert-dismissable">
                        <i class="fa fa-check"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        ' . $body . '
                    </div>';
                    break;
                case 'warning':
                    echo '<div class="alert alert-warning alert-dismissable">
                        <i class="fa fa-warning"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        ' . $body . '
                    </div>';
                    break;
                case 'info':
                    echo '<div class="alert alert-info alert-dismissable">
                        <i class="fa fa-info"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        ' . $body . '
                    </div>';
                    break;
                case 'danger':
                    echo '<div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        ' . $body . '
                    </div>';
                    break;
            }
        }
    }
}