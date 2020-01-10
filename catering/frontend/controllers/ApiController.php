<?php

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use frontend\models\Empl;

class ApiController extends ActiveController
{
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @return array
     */
    public function behaviors() 
    {
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
                'auth' => function ($login, $pass)
                {
                    if ($user = Empl::find()
                        ->where(['login' => $login])->one() 
                        and !empty($pass) 
                        and $user->validatePassword($pass)) {
                        return $user;
                    } return null;
                },
            ],
        ];
    }
}
