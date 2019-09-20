<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\{
    User,
    Status
};

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ($role === User::ROLE_USER)
            ? Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success'])
            : false
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'user.name',
            'name',
            'description',
            'status.name',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {edit-status} {delete}',
                'buttons' => [
                    'edit-status' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            $url);
                    },
                ],
                'visibleButtons' => [
                    'update' => function ($model) {
                        return ($model->user->role === User::ROLE_USER)
                            ? true : false;
                    },
                    'edit-status' => function ($model) {
                        if ($model->user->role === User::ROLE_ADMIN) {
                            return true;
                        }
                        if ($model->user->role === User::ROLE_MANAGER) {
                            if($model->status_id === Status::STATUS_NEW || $model->status_id === Status::STATUS_IN_WORK) {
                                return true;
                            }
                            else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    },
                    'delete' => function ($model) {
                        return $model->user->role === User::ROLE_ADMIN
                                ? true : false;
                    }
                ]
            ],
        ],
    ]); ?>
</div>
