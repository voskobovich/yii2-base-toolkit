<?php

namespace voskobovich\base\db;

/**
 * Class ActiveQuery.
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Scope for model status.
     *
     * @param int $status
     *
     * @return $this
     */
    public function status($status)
    {
        $this->andWhere(['status_key' => $status]);

        return $this;
    }

    /**
     * Scope for model type.
     *
     * @param int $type
     *
     * @return $this
     */
    public function type($type)
    {
        $this->andWhere(['type_key' => $type]);

        return $this;
    }

    /**
     * Scope for archive level.
     *
     * @param int $archive_level_key
     *
     * @return $this
     */
    public function archiveLevel($archive_level_key)
    {
        $this->andWhere(['archive_level_key' => $archive_level_key]);

        return $this;
    }
}
