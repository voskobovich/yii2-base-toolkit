<?php

namespace voskobovich\base\traits;

use ReflectionClass;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class ModelTrait.
 */
trait ModelTrait
{
    /**
     * Returns the form lowercase name that this model class should use.
     *
     * @param null $end
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function formId($end = null): string
    {
        /** @var Model $this */
        $name = $this->formName();

        if (empty($name)) {
            $reflector = new ReflectionClass($this);
            $name = $reflector->getShortName();
        }

        $result = mb_strtolower($name) . '-form';

        if (false === empty($end)) {
            $result .= '-' . $end;
        }

        return $result;
    }

    /**
     * @param ActiveRecord $model
     * @param string $defaultAttribute
     * @param array $attributesMap
     */
    public function populateErrors(ActiveRecord $model, $defaultAttribute, array $attributesMap = []): void
    {
        /** @var Model $this */
        $errors = $model->getErrors();

        foreach ($errors as $attribute => $messages) {
            $attribute = $attributesMap[$attribute] ?? $attribute;
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
