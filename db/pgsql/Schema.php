<?php

namespace voskobovich\base\db\pgsql;


/**
 * Class Schema
 * @package voskobovich\base\db\pgsql
 */
class Schema extends \yii\db\mysql\Schema
{
    const TYPE_CHAR = 'char';

    const CASCADE = 'cascade';
    const RESTRICT = 'restrict';
}