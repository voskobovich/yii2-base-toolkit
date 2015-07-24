<?php

namespace voskobovich\baseToolkit\db\mysql;


/**
 * Class Schema
 * @package voskobovich\baseToolkit\db\mysql
 */
class Schema extends \yii\db\mysql\Schema
{
    const TYPE_CHAR = 'char';

    const CASCADE = 'cascade';
    const RESTRICT = 'restrict';
}