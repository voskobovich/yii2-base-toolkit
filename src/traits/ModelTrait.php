<?php

namespace voskobovich\base\traits;

use ReflectionClass;
use yii\base\Model;


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
}