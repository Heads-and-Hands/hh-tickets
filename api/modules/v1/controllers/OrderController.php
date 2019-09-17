<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Order;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class OrderController extends Controller
{
    public $modelClass = 'common\models\Order';

//    public function actionIndex()
//    {
//        return new ActiveDataProvider([
//            'query' => Order::find(),
//            'sort'  => ['defaultOrder' => ['created_at' => SORT_DESC]],
//        ]);
//    }

//    public function actionCreate()
//    {
//        $model = new Order();
//        $request = \Yii::$app->request->post();
//        var_dump($request);die;
//        $model->attributes = $request;
//
//
//        if ($model->validate()) {
//            $model->save();
//
//            $request['id'] = $model->id;
//            $model->send();
//
//            return $model;
//        }
//
//        \Yii::$app->getResponse()->setStatusCode(400);
//
//        return $model->errors;
//    }
}