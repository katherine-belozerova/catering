<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Employee;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;

class EmployeeController extends ApiController
{
	public $modelClass = Employee::class;
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => HttpBasicAuth::class,
			'auth' => function ($login, $pass)
			{
				if ($user = Employee::find()->where(['login' => $login])->one() and !empty($pass) and $user->validatePassword($pass)) {
					return $user;
				} return null;
			},
		];
		$behaviors['access'] = [
			'class' => AccessControl::class,
			'denyCallback' => function ($rule, $action) { throw new \Exception('У Вас нет прав для доступа к данной странице'); },
			'rules' => [
				[
						'actions' => ['view', 'index', 'create', 'update'],
						'allow' => false,
						'roles' => ['?'],
				],
				[
						'actions' => ['view', 'index'],
						'allow' => true,
						'roles' => ['viewEmployee'],
				],
				[
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createEmployee'],
                ],
                [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['updateEmployee'],
                ],
			],
		];
		 return $behaviors;
  }
}
