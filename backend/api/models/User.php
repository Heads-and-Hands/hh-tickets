<?php

namespace backend\api\models;

use \frontend\models\User as FrontUser;

class User extends FrontUser
{
    public function fields()
    {
        return ['name'];
    }

    public function extraFields()
    {
        return [];
    }
}