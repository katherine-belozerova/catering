<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Login;
use yii\filters\AccessControl;
use frontend\controllers\EmployeeController;

class SiteController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        if (\Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            \Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
            \Yii::$app->end();
        }

        return [
            [
                'class' => \yii\filters\ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                    'xml' => \yii\web\Response::FORMAT_XML
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionIndex()
    {
    	return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new Login();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        return $model->login();
    }
}