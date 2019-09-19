<?php

namespace api\modules\v1\controllers;

use api\modules\v1\forms\OrderCreateForm;
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
        $order = Order::createNewOrder($form);
        $order->save();

//        if (!$order->save()) {
//            \Yii::$app->getResponse()->setStatusCode(400);
//            return '';
//        }

        return $order;
    }
}