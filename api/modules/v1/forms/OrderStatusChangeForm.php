<?php

namespace api\modules\v1\forms;

use yii\base\Model;
use common\models\{
    Order,
    Status
};

class OrderStatusChangeForm extends Model
{
    public $id;
    public $status_id;

    public function rules()
    {
        return [
            [['id', 'status_id'], 'integer'],
            [['id'], 'required', 'when' => function($model, $attribute) {
                $order = Order::findOne(['id' => $model->id]);
                if (!$order) {
                     $this->addError($attribute, 'Заявка с таким идентификатором не существует');
                }
            }],
            [['status_id'], 'required', 'when' => function($model, $attribute) {
                $status = Status::findOne(['id' => $model->status_id]);
                if (!$status) {
                    $this->addError($attribute, 'Статус с таким идентификатором не существует');
                }
                $order_status = Order::find()
                    ->andWhere(['id' => $model->id])
                    ->select('status_id')
                    ->scalar();
                if ($order_status == $this->$attribute) {
                    $this->addError($attribute, 'Заявка уже находится в этом статусе');
                } elseif ($order_status == Status::STATUS_NEW && $this->$attribute == Status::STATUS_DONE) {
                    $this->addError($attribute, 'Доступные статусы для этой заявки 2 и 3');
                } elseif ($order_status == Status::STATUS_IN_WORK
                    && ($this->$attribute == Status::STATUS_REJECTED
                        || $this->$attribute == Status::STATUS_NEW)) {
                    $this->addError($attribute, 'Доступный статус для этой заявки 4');
                } elseif (($order_status == Status::STATUS_REJECTED
                        || $order_status == Status::STATUS_DONE)
                    && ($this->$attribute == Status::STATUS_NEW
                        || $this->$attribute == Status::STATUS_IN_WORK
                        || $this->$attribute == Status::STATUS_DONE
                        || $this->$attribute == Status::STATUS_REJECTED)) {
                    $this->addError($attribute, 'Для этой заявки нет доступных статусов');
                }
            }],
        ];
    }
}