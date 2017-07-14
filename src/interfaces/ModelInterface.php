<?php

namespace voskobovich\base\interfaces;

use yii\db\ActiveRecord;

/**
 * Interface ModelInterface.
 */
interface ModelInterface
{
    /**
     * Returns the form lowercase name that this model class should use.
     *
     * @return string
     */
    public function formId();

    /**
     * @param ActiveRecord $model
     * @param string $defaultAttribute
     */
    public function populateErrors(ActiveRecord $model, $defaultAttribute);
}
