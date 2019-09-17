<?php

namespace api\modules\v1\controllers\base;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use \yii\rest\ActiveController;

/**
 * Контроллер родитель для контроллеров апи требующих авторизацию
*/
class Controller extends ActiveController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
            ],
        ]);
    }
}