<?php
namespace frontend\controllers;

<<<<<<< HEAD
use Yii;
use yii\base\InvalidParamException;
=======
use frontend\components\AuthHandler;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
<<<<<<< HEAD
=======
use frontend\components\MyAuthClient;
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
<<<<<<< HEAD
     * @inheritdoc
=======
     * {@inheritdoc}
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
     */
    public function behaviors()
    {
        return [
            'access' => [
<<<<<<< HEAD
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
=======
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'home'],
                'rules' => [
                    [
                        'actions' => ['redmine-auth', 'login'],
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
<<<<<<< HEAD
                        'actions' => ['logout'],
=======
                        'actions' => ['home','logout', 'redmine-auth'],
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
<<<<<<< HEAD
                'class' => VerbFilter::className(),
=======
                'class' => VerbFilter::class,
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
<<<<<<< HEAD
     * @inheritdoc
=======
     * {@inheritdoc}
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
<<<<<<< HEAD
=======

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
            $oauthClient = new MyAuthClient();
            $url = $oauthClient->buildAuthUrl();
            return Yii::$app->getResponse()->redirect($url);
        }
        (new AuthHandler($token))->handle();
        return $this->redirect('../order/index');
    }

    /**
     * Display inner page.
     *
     * @return mixed
     */
    public function actionHome()
    {
        return $this->render('home');
    }

    /**
     * Logs in a user.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
}
