<?php

namespace voskobovich\base\db;

use voskobovich\base\interfaces\ModelInterface;
use voskobovich\base\traits\ModelTrait;
use yii\base\ErrorException;

/**
 * Class ActiveRecord.
 */
class ActiveRecord extends \yii\db\ActiveRecord implements ModelInterface
{
    use ModelTrait;

    /**
     * Scenarios.
     */
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

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
}
