<?php

namespace api\modules\v1\controllers;

use api\modules\v1\forms\{
    OrderCreateForm,
    OrderStatusChangeForm
};
use api\modules\v1\models\Order;
use yii\rest\Controller;
use api\modules\v1\components\Pagination;

class OrderController extends Controller
{
    public $modelClass = Order::class;

    public function actionIndex()
    {
        $query = Order::find();
        $limit = \Yii::$app->request->get('limit');
        $offset = \Yii::$app->request->get('offset');


        $pagination = new Pagination([
            'totalCount' => $query->count(),
        ]);

        $order['data'] = $query
            ->offset($offset)
            ->limit($limit)
            ->all();

        $order['recordsTotal'] = $pagination->totalCount;
        $order['recordsFiltered'] = $pagination->totalCount;

        return $order;
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