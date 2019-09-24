<?php

namespace api\modules\v1\controllers;

use api\modules\v1\forms\{
    OrderCreateForm,
    OrderStatusChangeForm
};
use api\modules\v1\models\Order;
use common\models\Auth;
use common\models\User;
use yii\filters\AccessControl;
use yii\rest\Controller;
use api\modules\v1\components\Pagination;

class OrderController extends Controller
{
    public $modelClass = Order::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['login', 'logout', 'signup'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['login', 'signup'],
                    'roles' => ['?'],
                ],
                [
                    'allow' => true,
                    'actions' => ['logout'],
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $login = \Yii::$app->request->authUser;
        $auth_key= \Yii::$app->request->authPassword;

        $token = \Yii::$app->request->get('token');

        $user = User::find()
            ->andWhere(['login' => $login])
            ->andWhere(['auth_key' => $auth_key])
            ->one();

        $auth = Auth::find()
            ->andWhere(['token' => $token])
            ->one();

        if ($user) {
            if($auth) {
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
            } else {
                return 'Токен отсутствует или введен не верно';
            }
        } else {
            return 'Логин или пароль не верный';
        }
    }

    public function actionCreate()
    {
        $login = \Yii::$app->request->authUser;
        $auth_key= \Yii::$app->request->authPassword;

        $token = \Yii::$app->request->get('token');

        $user = User::find()
            ->andWhere(['login' => $login])
            ->andWhere(['auth_key' => $auth_key])
            ->one();

        $auth = Auth::find()
            ->andWhere(['token' => $token])
            ->one();

        if ($user) {
            if ($auth) {
                $form = new OrderCreateForm();
                $form->load(\Yii::$app->request->post(), '');
                if ($form->validate()) {
                    $order = Order::createNewOrder($form);
                    return $order;
                } else {
                    return $form->errors;
                }
            } else {
                return 'Токен отсутствует или введен не верно';
            }
        } else {
            return 'Логин или пароль не верный';
        }
    }

    public function actionUpdate()
    {
        $login = \Yii::$app->request->authUser;
        $auth_key= \Yii::$app->request->authPassword;

        $token = \Yii::$app->request->get('token');

        $user = User::find()
            ->andWhere(['login' => $login])
            ->andWhere(['auth_key' => $auth_key])
            ->one();

        $auth = Auth::find()
            ->andWhere(['token' => $token])
            ->one();

        if ($user) {
            if ($auth) {
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
            } else {
                return 'Токен отсутствует или введен не верно';
            }
        } else {
            return 'Логин или пароль не верный';
        }
    }
}