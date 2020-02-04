<?php

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use frontend\models\Employee;

class ApiController extends ActiveController
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUPER_ADMIN = 5;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors() 
    {
        if (\Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            \Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
            \Yii::$app->end();
        }

        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                    'xml' => \yii\web\Response::FORMAT_XML
                ],
            ],

            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ],
        ];
    }
}
