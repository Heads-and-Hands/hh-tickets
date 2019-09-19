<?php

namespace api\modules\v1\controllers;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use \yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\HttpBasicAuth;

class Controller extends ActiveController
{
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
    }

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [
//                    'application/xml' => \yii\web\Response::FORMAT_XML,
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ]
            ]
        ];
    }
}