<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Order;
use PHPUnit\Framework\Error\Error;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
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
        $model = new Order();
        $request = \Yii::$app->request->post();
        $model->attributes = $request;
        if (!$model->save()) {
            \Yii::$app->getResponse()->setStatusCode(400);
            return '';
        }

        return $model;
    }
}