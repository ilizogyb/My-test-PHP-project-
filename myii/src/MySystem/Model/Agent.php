<?php

namespace MySystem\Model;

use Core\Model\ActiveRecord;

class Agent extends ActiveRecord
{
    public $fname;
    public $lname;

    public static function getTable()
    {
        return 'agents';
    }

}
