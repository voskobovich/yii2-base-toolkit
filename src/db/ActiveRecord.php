<?php

namespace voskobovich\base\db;

use voskobovich\base\interfaces\ModelInterface;
use voskobovich\base\traits\ModelTrait;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;


/**
 * Class ActiveRecord
 * @package voskobovich\base\db
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord implements ModelInterface
{
    use ModelTrait;

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
     * @param bool $asArray
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
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