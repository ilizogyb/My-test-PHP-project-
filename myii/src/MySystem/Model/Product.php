<?php

namespace MySystem\Model;

use Core\Model\ActiveRecord;

class Product extends ActiveRecord
{
    public $producttitle;
    public $productprice;

    public static function getTable()
    {
        return 'products';
    }

}
