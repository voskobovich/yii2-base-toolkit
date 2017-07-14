<?php

namespace voskobovich\base\forms;

use voskobovich\base\interfaces\ModelInterface;
use voskobovich\base\traits\ModelTrait;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class FindableFormAbstract.
 *
 * @property string $sourceScenario
 * @property string $defaultAttribute
 * @property ActiveRecord $_source
 * @property ActiveRecord $source
 */
abstract class FindableFormAbstract extends Model implements ModelInterface
{
    use ModelTrait;

    /**
     * Editable model class name.
     *
     * @var string
     */
    public static $sourceClass;

    /**
     * Default scenario for editable model.
     *
     * @var string
     */
    public $sourceScenario = ActiveRecord::SCENARIO_DEFAULT;

    /**
     * Default attribute for print error.
     *
     * @var string
     */
    public $defaultAttribute;

    /**
     * @var ActiveRecord
     */
    private $_source;

    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!static::$sourceClass) {
            throw new InvalidConfigException('Static property "sourceClass" must be contain source model class name.');
        }

        if (!is_subclass_of(static::$sourceClass, ActiveRecord::className())) {
            throw new InvalidConfigException('Model in "sourceClass" must to be inherited from "' . ActiveRecord::className() . '"');
        }

        $this->_source = new static::$sourceClass();

        parent::init();
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->getSource()->getPrimaryKey();
    }

    /**
     * Populate attributes value of source model.
     */
    public function populateSourceAttributes(): void
    {
        $attributes = array_intersect_key(
            $this->getAttributes(),
            array_flip($this->source->safeAttributes())
        );
        $this->source->setAttributes($attributes);
    }

    /**
     * Populate attributes value.
     */
    public function populateAttributes(): void
    {
        $attributes = array_intersect_key(
            $this->_source->getAttributes(),
            $this->getAttributes()
        );
        $this->setAttributes($attributes, false);
    }

    /**
     * @param ActiveRecord $source
     */
    public function setSource($source): void
    {
        $this->_source = $source;
        $this->_source->scenario = $this->sourceScenario;

        $this->populateAttributes();
    }

    /**
     * @return ActiveRecord
     */
    public function getSource(): ActiveRecord
    {
        return $this->_source;
    }

    /**
     * @param $id
     *
     * @return null|FindableFormAbstract
     */
    public static function findOne($id): ?FindableFormAbstract
    {
        $model = new static();

        /** @var ActiveRecord $source */
        $source = static::$sourceClass;
        $source = $source::findOne($id);

        if (null === $source) {
            return null;
        }

        $model->setSource($source);

        return $model;
    }

    /**
     * @param null $attributeNames
     * @param bool $clearErrors
     *
     * @throws \yii\base\InvalidParamException
     *
     * @return bool
     */
    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if (parent::validate($attributeNames, $clearErrors)) {
            $this->populateSourceAttributes();

            $source = $this->source;

            if (!$source->validate()) {
                if ($this->defaultAttribute && $source->hasErrors()) {
                    $this->populateErrors($source, $this->defaultAttribute);
                }

                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @throws \yii\base\InvalidParamException
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null): bool
    {
        if ($runValidation && false === $this->validate($attributeNames)) {
            Yii::info('Model not saved due to validation error.', __METHOD__);

            return false;
        }

        $this->populateSourceAttributes();

        $source = $this->source;
        $result = $source->save();

        if (!$result) {
            if ($this->defaultAttribute && $source->hasErrors()) {
                $this->populateErrors($source, $this->defaultAttribute);
            }

            return false;
        }

        return true;
    }
}
