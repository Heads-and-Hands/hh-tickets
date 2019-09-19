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
            'name',
            'description',
            'status_id',
            'created_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['status_id'], 'default', 'value' => self::STATUS_NEW],
            [['name', 'description'], 'string', 'max' => 100],
        ];
    }
}