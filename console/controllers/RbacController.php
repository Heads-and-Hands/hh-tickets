<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $createOrder = $auth->createPermission('createOrder');
        $createOrder->description = 'Create a order';
        $auth->add($createOrder);

        $viewYourOrders = $auth->createPermission('viewYourOrders');
        $viewYourOrders->description = 'View your orders';
        $auth->add($viewYourOrders);

        $viewOrderStatusNewInWork = $auth->createPermission('viewOrderStatusNewInWork');
        $viewOrderStatusNewInWork->description = 'Viewing applications in the status new and in work';
        $auth->add($viewOrderStatusNewInWork);

        $changeStatusCertainSequence = $auth->createPermission('changeStatusCertainSequence');
        $changeStatusCertainSequence->description = 'Сhange of status in a certain sequence';
        $auth->add($changeStatusCertainSequence);

        $viewAllOrders = $auth->createPermission('viewAllOrders');
        $viewAllOrders->description = 'View all orders';
        $auth->add($viewAllOrders);

        $changeStatus = $auth->createPermission('changeStatus');
        $changeStatus->description = 'Сhange of status';
        $auth->add($changeStatus);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createOrder);
        $auth->addChild($user, $viewYourOrders);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $viewOrderStatusNewInWork);
        $auth->addChild($manager, $changeStatusCertainSequence);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewAllOrders);
        $auth->addChild($admin, $changeStatus);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $manager);

        $auth->assign($user, 6);
        $auth->assign($manager, 362);
        $auth->assign($admin, 232);
    }
}