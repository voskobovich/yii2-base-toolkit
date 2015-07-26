<?php

namespace voskobovich\base\db;


/**
 * Class ActiveQuery
 * @package voskobovich\base\db
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Init
     */
    public function init()
    {
        parent::init();

        /** @var \yii\db\ActiveRecord $tModel */
        $tModel = new $this->modelClass;
        $this->from(['t' => $tModel::tableName()]);
    }

    /**
     * Scope for model status
     * @param int $status
     * @return $this
     */
    public function status($status)
    {
        $this->andWhere(['t.status_key' => $status]);
        return $this;
    }

    /**
     * Scope for model type
     * @param int $type
     * @return $this
     */
    public function type($type)
    {
        $this->andWhere(['t.type_key' => $type]);

        return $this;
    }
}