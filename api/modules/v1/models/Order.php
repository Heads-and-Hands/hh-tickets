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

    public static function createNewOrder($form)
    {
        $order = new self([
            'user_id' => $form->user_id,
            'name' => $form->name,
            'description' => $form->description,
            'status_id' => $form->status_id,
            'created_at' => $form->created_at,
        ]);
        if ($order->save()) {
            return $order;
        }
        return null;
    }
}