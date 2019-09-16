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
                        'actions' => ['logout', 'index', 'create', 'update', 'edit-status', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function getRole() {
        return $role = User::find()
            ->select('role')
            ->where(['id' => Yii::$app->user->id])
            ->scalar();
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
            'role' => $this->getRole(),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->getRole() === Order::ROLE_USER){
            $model = new Order();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionEditStatus($id)
    {
        if ($this->getRole() === Order::ROLE_ADMIN || $this->getRole() === Order::ROLE_MANAGER){
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
        } else {
            return $this->redirect('index');
        }
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
        if ($this->getRole() === Order::ROLE_USER){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }

            return $this->render('update', [
                'model' => $model,
                'id' => $id,
            ]);
        } else {
            return $this->redirect('index');
        }
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
        if ($this->getRole() === 1){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            return $this->redirect('index');
        }
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
