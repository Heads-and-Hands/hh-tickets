<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property int $status_id
 * @property string $created_at
 *
 * @property Status $status
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id'], 'default', 'value' => Status::STATUS_NEW],
            [['user_id'], 'default', 'value' => \Yii::$app->user->id],
            [['user_id', 'status_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'description'], 'string', 'max' => 100],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user.name' => 'Пользователь',
            'name' => 'Название',
            'description' => 'Описание',
            'status_id' => 'Статус',
            'created_at' => 'Дата создания',
            'status.name' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRole() {
        return $role = User::find()
            ->select('role')
            ->where(['id' => \Yii::$app->user->id])
            ->scalar();
    }
}
