<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Empl;
use common\models\Employee;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;

class EmployeeController extends ApiController
{
	const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUPER_ADMIN = 5;

	public $modelClass = Empl::class;

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['access'] = [
			'class' => AccessControl::class,
			'denyCallback' => function ($rule, $action) 
				{ 
					throw new \Exception('У Вас нет прав для доступа к данной странице'); 
				},
			'rules' => [
				[
					'actions' => ['view', 'index', 'create', 'update', 'dismiss', 'return'],
					'allow' => false,
					'roles' => ['?'],
				],
				[
					'actions' => ['view', 'index'],
					'allow' => true,
					'roles' => ['viewEmployee'],
				],
				[
                    'actions' => ['create', 'dismiss', 'restore-work'],
                    'allow' => true,
                    'roles' => ['createEmployee'],
                ],
                [
                    'actions' => ['update', 'dismiss', 'restore-work'],
                    'allow' => true,
                    'roles' => ['updateEmployee'],
                ],
			],
		];
		 	return $behaviors;
  	}

  	public function actionDismiss($id)
    {
        $model = $this->findModel($id);
	    Yii::$app->db->createCommand()->update('employee', ['status' => self::STATUS_DELETED], 'id='.$model->id)->execute();
	    return $this->redirect(['index']);
    }

    public function actionRestoreWork($id)
	{
	    $model = $this->findModel($id);
	    Yii::$app->db->createCommand()->update('employee', ['status' => self::STATUS_ACTIVE], 'id='.$model->id)->execute();
	    return $this->redirect(['index']);
	}

  	protected function findModel($id)
    {
        if (!empty(($model = Empl::findOne($id)))) {
            return $model;
        } return false;
    }
}
