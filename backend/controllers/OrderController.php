<?php

namespace backend\controllers;

use common\models\Status;
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
                        'actions' => [
                            'logout',
                            'index',
                            'create',
                            'edit-status',
                            'update',
                            'delete',
                        ],
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

    public function checkAccess ($action, $model = null)
    {
        switch ($this->action->id)
        {
            case 'create':
                if ((new User)->getRole() === User::ROLE_USER){
                    return true;
                }
                break;
            case 'edit-status':
                if ((new User)->getRole() === User::ROLE_ADMIN
                    || (new User)->getRole() === User::ROLE_MANAGER){
                    return true;
                }
                break;
            case 'update':
                if ((new User)->getRole() === User::ROLE_USER){
                    return true;
                }
                break;
            case 'delete':
                if ((new User)->getRole() === User::ROLE_ADMIN){
                    return true;
                }
                break;
        }
        if (!\Yii::$app->user->can($action, ['model' => $model]))
        {
            return $this->redirect('index');
        }
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => (new User())->getRole(),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkAccess($this->action->id);

        $model = new Order();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionEditStatus($id)
    {
        $this->checkAccess($this->action->id);

        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $statusesManager = null;

        if ($model->status_id == Status::STATUS_NEW) {
            $statusesManager = [
                '2' => 'В работе',
                '3' => 'Отклонена',
            ];
        } elseif ($model->status_id == Status::STATUS_IN_WORK) {
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
        $this->checkAccess($this->action->id);

        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
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
        $this->checkAccess($this->action->id);

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
