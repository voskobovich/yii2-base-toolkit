<?php

namespace voskobovich\base\db;

use voskobovich\base\interfaces\ModelInterface;
use voskobovich\base\traits\ModelTrait;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

/**
 * Class ActiveRecord.
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord implements ModelInterface
{
    use ModelTrait;

    /**
     * Scenarios.
     */
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    /**
     * {@inheritdoc}
     *
     * @return ActiveQuery
     */
    public static function find(): ActiveQuery
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * Main primary key of model for sorting, selecting and more.
     *
     * @throws ErrorException
     *
     * @return string
     */
    public function getMainPk(): string
    {
        $pkName = static::primaryKey();
        if (is_array($pkName)) {
            if (count($pkName) > 1) {
                throw new ErrorException('Composite foreign keys are not allowed.');
            }
            $pkName = $pkName[0];
        }

        return (string)$pkName;
    }

    /**
     * Relation class name map.
     *
     * @return array
     */
    public function relationsClassMap(): array
    {
        return [];
    }

    /**
     * Get actual class name of relation.
     *
     * @param $className
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function buildRelationClass($className): string
    {
        $relationsClassMap = $this->relationsClassMap();

        if (false === empty($relationsClassMap[$className])) {
            return $relationsClassMap[$className];
        }

        $classShortName = substr(strrchr($className, '\\'), 1);

        if (empty($classShortName)) {
            throw new \InvalidArgumentException('Invalid class name "' . $className . '"');
        }

        return str_replace(strrchr(static::class, '\\'), '', static::class) . '\\' . $classShortName;
    }

    /**
     * Query for building list for DropDown.
     *
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     *
     * @return ActiveQuery
     */
    public static function listAllQueryBuilder($keyField, $valueField, $asArray): ActiveQuery
    {
        $query = static::find();

        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return $query;
    }

    /**
     * Array for DropDownList.
     *
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     *
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = false): array
    {
        $query = static::listAllQueryBuilder($keyField, $valueField, $asArray);

        return ArrayHelper::map(
            $query->all(),
            $keyField,
            $valueField
        );
    }

    /**
     * Formatted date create record.
     *
     * @param string $format
     * @param string $emptyLabel
     *
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     *
     * @return string
     */
    public function getCreated($format = 'long', $emptyLabel = '-'): string
    {
        if (empty($this->created_at)) {
            return $emptyLabel;
        }

        return Yii::$app->formatter->asDate($this->created_at, $format);
    }

    /**
     * Formatted date update record.
     *
     * @param string $format
     * @param string $emptyLabel
     *
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     *
     * @return string
     */
    public function getUpdated($format = 'long', $emptyLabel = '-'): string
    {
        if (empty($this->updated_at)) {
            return $emptyLabel;
        }

        return Yii::$app->formatter->asDate($this->updated_at, $format);
    }
}
