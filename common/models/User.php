<?php

namespace common\models;

use \frontend\models\User as FrontUser;

class User extends FrontUser
{
    public function fields()
    {
        return [
            'name',
            'iss' => function($model){
                return $model->id == 1 ? 'rrr' : 'ddd';
            }
        ];
    }

    public function extraFields()
    {
        return [];
    }
}