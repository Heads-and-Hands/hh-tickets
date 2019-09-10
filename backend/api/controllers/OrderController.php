<?php

namespace backend\api\controllers;

use frontend\models\Order;
use \yii\rest\ActiveController;

class OrderController extends ActiveController
{
    public $modelClass = Order::class;
}
