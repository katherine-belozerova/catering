<?php

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use frontend\models\Empl;

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
                'class' => HttpBasicAuth::class,
                'except' => ['options'],
                'auth' => function ($login, $pass)
                {
                    if ($user = Empl::find()
                            ->where(['login' => $login,
                                'status' => self::STATUS_ACTIVE])
                            ->orWhere(['login' => $login,
                                'status' => self::STATUS_SUPER_ADMIN])
                            ->one()
                        and !empty($pass) 
                        and $user->validatePassword($pass)) {
                        return $user;
                    } return null;
                },
            ],
        ];
    }
}
