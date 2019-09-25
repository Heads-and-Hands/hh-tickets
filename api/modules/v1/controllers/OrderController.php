<?php

namespace api\modules\v1\controllers;

use common\models\Auth;
use \yii\rest\Controller;
use api\modules\v1\models\Order;
use api\modules\v1\components\Pagination;
use api\modules\v1\forms\{
    OrderCreateForm,
    OrderStatusChangeForm
};

class OrderController extends Controller
{
    public $modelClass = Order::class;


    public function getToken ()
    {
        $token = \Yii::$app->request->headers->get('token');

        $auth = Auth::find()
            ->andWhere(['token' => $token])
            ->one();

        if (!$auth)
        {
            return false;
        }

        return true;
    }

    public function actionIndex()
    {
        if (!$this->getToken()) {
            return 'Токен не введен или введен не верно';
        }

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
        if (!$this->getToken()) {
            return 'Токен не введен или введен не верно';
        }

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
        if (!$this->getToken()) {
            return 'Токен не введен или введен не вернон';
        }

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