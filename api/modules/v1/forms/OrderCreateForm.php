<?php

namespace api\modules\v1\forms;

use yii\base\Model;
use common\models\Order;

class OrderCreateForm extends Model
{
    public $id;
    public $name;
    public $user_id;
    public $description;
    public $status_id;
    public $created_at;

    public function rules()
    {
        return [
            [['id', 'user_id', 'status_id'], 'integer'],
            [['status_id'], 'default', 'value' => Order::STATUS_NEW],
            [['name', 'description'], 'string', 'max' => 100],
        ];
    }
}