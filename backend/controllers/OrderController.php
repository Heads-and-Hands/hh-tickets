<?php

namespace backend\controllers;

use Yii;
use common\models\Order;
use common\models\User;
use backend\models\OrderSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function () {
                            if ($this->getRole() === Order::ROLE_USER){
                                return true;
                            } else {
                                return $this->redirect('index');
                            }
                        }
                    ],
                    [
                        'actions' => ['edit-status'],
                        'allow' => true,
                        'matchCallback' => function () {
                            if ($this->getRole() === Order::ROLE_ADMIN
                                || $this->getRole() === Order::ROLE_MANAGER){
                                return true;
                            } else {
                                return $this->redirect('index');
                            }
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function () {
                            if ($this->getRole() === Order::ROLE_USER){
                                return true;
                            } else {
                                return $this->redirect('index');
                            }
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function () {
                            if ($this->getRole() === Order::ROLE_ADMIN){
                                return true;
                            } else {
                                return $this->redirect('index');
                            }
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => (new Order())->getRole(),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionEditStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $statusesManager = null;

        if ($model->status_id == 1) {
            $statusesManager = [
                '2' => 'В работе',
                '3' => 'Отклонена',
            ];
        } elseif ($model->status_id == 2) {
            $statusesManager = [
                '4' => 'Сделана',
            ];
        }

        $statusesAdmin = [
            '1' => 'Новая',
            '2' => 'В работе',
            '3' => 'Отклонена',
            '4' => 'Сделана',
        ];

        return $this->render('edit-status', [
            'model' => $model,
            'statusesAdmin' => $statusesAdmin,
            'statusesManager' => $statusesManager,
            'id' => $model->id
        ]);
    }

    /**
     * Updates an existing Status model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
