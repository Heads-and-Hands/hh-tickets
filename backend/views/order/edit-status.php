<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Order;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Изменение статуса заявки: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-update">

    <div class="order-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= ($model->isNewRecord) ? $form->field($model, 'name')->textInput(['maxlength' => true]) : '' ?>

        <?= ($model->isNewRecord) ? $form->field($model, 'description')->textarea(['rows' => '6'], ['maxlength' => true]) : '' ?>

        <?= (!$model->isNewRecord && $model->user->role == Order::ROLE_ADMIN) ? $form->field($model, 'status_id')->dropDownList($statusesAdmin) : '' ?>

        <?= (!$model->isNewRecord && $model->user->role == Order::ROLE_MANAGER) ? $form->field($model, 'status_id')->dropDownList($statusesManager) : '' ?>

        <div class="form-group">
            <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
