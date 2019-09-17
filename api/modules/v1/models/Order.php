<?php

namespace api\modules\v1\models;

use \common\models\Order as BaseOrder;

class Order extends BaseOrder
{
    public function fields()
    {
        return [
            'id',
            'name',
            'user_id',
            'description',
            'status_id',
            'created_at',
        ];
    }
}