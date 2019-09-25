<?php
namespace backend\controllers;

use backend\components\AuthHandler;
use backend\components\RedmineClient;
use Yii;
use backend\controllers\base\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return $this->render('login');
    }

    /**
     * @param null $token
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionRedmineAuth($token = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('home');
        }
        if (!$token) {
            $oauthClient = new RedmineClient();
            $url = $oauthClient->getUrl();
            return Yii::$app->getResponse()->redirect($url);
        }
        (new AuthHandler($token))->handle();
        return $this->redirect('/admin/order/index');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
