<?php

namespace voskobovich\baseToolkit\db;

use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;


/**
 * Class ActiveRecord
 * @package voskobovich\baseToolkit\db
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
     * Find model
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->load($params)) {
            return $dataProvider;
        }

        return $dataProvider;
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
     * Checking the alteration of the attribute after saving the model
     * @param $attributeName
     * @param $changedAttributes
     * @return bool
     */
    public function isAttributeModified($attributeName, $changedAttributes)
    {
        return isset($changedAttributes[$attributeName]) &&
        $changedAttributes[$attributeName] != $this->oldAttributes[$attributeName];
    }

    /**
     * @inheritdoc
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
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
     * Find by
     * @param $id
     * @param null $where
     * @return mixed
     */
    public static function findByPk($id, $where = null)
    {
        /** @var ActiveRecord $model */
        $query = static::find()->andWhere('id = :id', [':id' => $id]);

        if (is_array($where)) {
            $query->where($where);
        }

        return $query->one();
    }

    /**
     * Formatted date create record
     * @param string $format
     * @param bool $plural
     * @return string
     */
    public function getCreated($format = 'd M Y H:i', $plural = true)
    {
        $dateFormatter = Yii::$app->get('dateFormatter', false);

        if (empty($this->created_at)) {
            if ($dateFormatter) {
                return $dateFormatter->emptyLabel;
            }
            return '-';
        }

        $date = new \DateTime($this->created_at);

        if ($dateFormatter) {
            return $dateFormatter->format($date, $format, $plural);
        }
        return $date->format($format);
    }

    /**
     * Formatted date update record
     * @param string $format
     * @param bool $plural
     * @return string
     */
    public function getUpdated($format = 'd M Y H:i', $plural = true)
    {
        $dateFormatter = Yii::$app->get('dateFormatter', false);

        if (empty($this->updated_at)) {
            if ($dateFormatter) {
                return $dateFormatter->emptyLabel;
            }
            return '-';
        }

        $date = new \DateTime($this->updated_at);

        if ($dateFormatter) {
            return $dateFormatter->format($date, $format, $plural);
        }
        return $date->format($format);
    }

    /**
     * Object name for print in Error Message
     * @return mixed
     */
    public function getNameForError()
    {
        return $this->id;
    }
}