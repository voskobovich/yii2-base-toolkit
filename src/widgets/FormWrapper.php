<?php

namespace voskobovich\base\widgets;

use InvalidArgumentException;
use voskobovich\base\interfaces\ModelInterface;
use yii\db\ActiveRecord;
use yii\base\Widget;


/**
 * Class FormWrapper
 * @package voskobovich\base\widgets
 *
 * @property ActiveRecord $model
 */
class FormWrapper extends Widget
{
    /**
     * Model class name
     * @var string
     */
    public $modelClass;

    /**
     * Init model attributes
     * @var array
     */
    public $initAttributes;

    /**
     * @var ActiveRecord|ModelInterface
     */
    private $_model;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->modelClass) {
            throw new InvalidArgumentException('Param "modelClass" must be non-empty');
        }

        if (!is_subclass_of($this->modelClass, 'voskobovich\base\interfaces\ModelInterface')) {
            throw new InvalidArgumentException('Param "modelClass" must be extend "voskobovich\base\interfaces\ModelInterface"');
        }

        $this->_model = new $this->modelClass;
        $this->_model->setAttributes($this->initAttributes);

        parent::init();
    }

    /**
     * @return ActiveRecord|ModelInterface
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @return string
     */
    public function formId()
    {
        return $this->id . '-' . $this->_model->formId();
    }
}