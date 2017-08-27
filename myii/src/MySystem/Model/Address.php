<?php

namespace MySystem\Model;

use Core\Model\ActiveRecord;

class Address extends ActiveRecord
{
    public $agentsid;
    public $address;

    public static function getTable()
    {
        return 'address';
    }

}
