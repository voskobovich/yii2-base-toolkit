<?php

namespace voskobovich\baseToolkit\db\pgsql;


/**
 * Class Schema
 * @package voskobovich\baseToolkit\db\pgsql
 */
class Schema extends \yii\db\mysql\Schema
{
    const TYPE_CHAR = 'char';

    const CASCADE = 'cascade';
    const RESTRICT = 'restrict';
}