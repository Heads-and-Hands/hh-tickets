<?php

namespace common\models;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $name
 *
 * @property Order[] $orders
 */
class Status extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_REJECTED = 3;
    const STATUS_DONE = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['status_id' => 'id']);
    }
}
