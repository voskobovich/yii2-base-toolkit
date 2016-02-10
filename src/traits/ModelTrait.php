<?php

namespace voskobovich\base\traits;

use ReflectionClass;
use yii\base\Model;
use yii\db\ActiveRecord;


/**
 * Class ModelTrait
 * @package voskobovich\base\traits
 */
trait ModelTrait
{
    /**
     * Returns the form lowercase name that this model class should use.
     * @return string
     */
    public function formId()
    {
        /** @var Model $this */
        $name = $this->formName();

        if (empty($name)) {
            $reflector = new ReflectionClass($this);
            $name = $reflector->getShortName();
        }

        return mb_strtolower($name) . '-form';
    }

    /**
     * @param ActiveRecord $model
     * @param string $defaultAttribute
     * @param array $attributesMap
     */
    public function populateErrors(ActiveRecord $model, $defaultAttribute, $attributesMap = [])
    {
        /** @var Model $this */
        $errors = $model->getErrors();

        foreach ($errors as $attribute => $messages) {
            $attribute = isset($attributesMap[$attribute])
                ? $attributesMap[$attribute]
                : $attribute;
            if (false === $this->hasProperty($attribute)) {
                if (!method_exists($this, 'hasAttribute')) {
                    $attribute = $defaultAttribute;
                } elseif (false === $this->hasAttribute($attribute)) {
                    $attribute = $defaultAttribute;
                }
            }
            foreach ($messages as $mes) {
                $this->addError($attribute, $mes);
            }
        }
    }
}