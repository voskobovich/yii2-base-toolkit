<?php

namespace voskobovich\base\db;

use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;


/**
 * Class ActiveRecord
 * @package voskobovich\base\db
 *
 * @property integer id
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Scenarios
     */
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    /**
     * @inheritdoc
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * Array for DropDownList
     *
     * @param string $keyField
     * @param string $valueField
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name')
    {
        $models = static::find()
            ->all();

        $items = [];

        foreach ($models as $model) {
            $key = $model->{$keyField};
            $items[$key] = $model->{$valueField};
        }

        return $items;
    }

    /**
     * Main primary key of model for sorting, selecting and more
     * @return string
     * @throws ErrorException
     */
    public function getMainPk()
    {
        $pkName = $this->primaryKey();
        if (is_array($pkName)) {
            if (count($pkName) > 1) {
                throw new ErrorException('Composite foreign keys are not allowed.');
            }
            $pkName = $pkName[0];
        }
        return (string)$pkName;
    }

    /**
     * Formatted date create record
     * @param string $format
     * @param string $emptyLabel
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreated($format = 'long', $emptyLabel = '-')
    {
        if (empty($this->created_at)) {
            return $emptyLabel;
        }

        return Yii::$app->formatter->asDate($this->created_at, $format);
    }

    /**
     * Formatted date update record
     * @param string $format
     * @param string $emptyLabel
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getUpdated($format = 'long', $emptyLabel = '-')
    {
        if (empty($this->updated_at)) {
            return $emptyLabel;
        }

        return Yii::$app->formatter->asDate($this->updated_at, $format);
    }
}