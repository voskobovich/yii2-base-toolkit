<?php

namespace voskobovich\base\db\mysql;


/**
 * Class Schema
 * @package voskobovich\base\db\mysql
 */
class Schema extends \yii\db\mysql\Schema
{
    const TYPE_CHAR = 'char';

    const CASCADE = 'cascade';
    const RESTRICT = 'restrict';
}