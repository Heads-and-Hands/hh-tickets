<?php

namespace api\modules\v1\controllers;

use api\modules\v1\forms\{
    OrderCreateForm,
    OrderStatusChangeForm
};
use api\modules\v1\models\Order;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class OrderController extends Controller
{
    public $modelClass = Order::class;

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Order::find(),
            'sort'  => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
    }

    public function actionCreate()
    {
        $form = new OrderCreateForm();
        $form->load(\Yii::$app->request->post(), '');
        if ($form->validate()) {
            $order = Order::createNewOrder($form);
            return $order;
        } else {
           return $form->errors;
        }
    }

    public function actionUpdate()
    {
        $form = new OrderStatusChangeForm();
        $form->load(\Yii::$app->request->post(), '');
        if ($form->validate()) {
            $order = Order::findOne(['id' => $form->id]);
            $order->updateAttributes([
                'status_id' => $form->status_id,
            ]);
            return $order;
        } else {
            return $form->errors;
        }
    }
}