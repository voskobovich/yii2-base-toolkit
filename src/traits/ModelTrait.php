<?php

namespace voskobovich\base\traits;

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
        return mb_strtolower($this->formName()) . '-form';
    }
}