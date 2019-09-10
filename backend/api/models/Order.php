<?php

namespace backend\api\models;

use \frontend\models\Order as FrontOrder;

class Order extends FrontOrder
{
    public function fields()
    {
        return ['name'];
    }

    public function extraFields()
    {
        return [];
    }
}