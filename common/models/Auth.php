<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth".
 *
 * @property int $id
 * @property int $user_id
 * @property int $redmine_id
 * @property string $token
 *
 * @property User $user
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'redmine_id', 'token'], 'required'],
            [['user_id', 'redmine_id'], 'default', 'value' => null],
            [['user_id', 'redmine_id'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'redmine_id' => 'Redmine ID',
            'token' => 'Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
