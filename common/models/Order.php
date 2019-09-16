<?php

namespace common\models;

use Yii;
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
    const STATUS_NEW = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_REJECTED = 3;
    const STATUS_DONE = 4;

    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_USER = 3;

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
            [['status_id'], 'default', 'value' => self::STATUS_NEW],
            [['user_id'], 'default', 'value' => Yii::$app->user->identity->getId()],
            [['user_id', 'status_id'], 'integer'],
            [['user_id', 'name', 'description', 'status_id'], 'required'],
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
}
