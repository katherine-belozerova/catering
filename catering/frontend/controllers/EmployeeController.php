<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Empl;
use common\models\Employee;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;

class EmployeeController extends ApiController
{
	const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUPER_ADMIN = 5;

	public $modelClass = Empl::class;

    protected function verbs()
    {
        return [
            'create' => ['POST', 'OPTIONS'],
            'view' => ['GET', 'OPTIONS'],
            'edit' => ['POST', 'OPTIONS'],
            'dismiss' => ['POST', 'OPTIONS'],
            'restore-work' => ['POST', 'OPTIONS'],
            'staff' => ['GET', 'OPTIONS'],
            'dismissed-staff' => ['GET', 'OPTIONS'],
            'sort-by' => ['GET', 'OPTIONS'],
            ];
    }

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'denyCallback' => function ($rule, $action)
				{
					throw new \Exception('У Вас нет прав для доступа к данной странице');
				},
			'rules' => [
				[
					'actions' => ['view', 'create', 'update', 'dismiss', 'restore-work',
                        'staff', 'dismissed-staff', 'edit'],
					'allow' => false,
					'roles' => ['?'],
				],
				[
					'actions' => ['view', 'staff', 'dismissed-staff', 'sort-by'],
					'allow' => true,
					'roles' => ['viewEmployee'],
				],
				[
                    'actions' => ['create', 'dismiss', 'restore-work', 'edit'],
                    'allow' => true,
                    'roles' => ['createEmployee'],
                ],
                [
                    'actions' => ['dismiss', 'restore-work', 'edit'],
                    'allow' => true,
                    'roles' => ['updateEmployee'],
                ],
			],
		];
		 	return $behaviors;
  	}

  	public function actionSortBy($sort)
    {
        $sorting = Empl::find()
            ->orderBy([$sort => SORT_ASC])
            ->all();
        return $sorting;
    }

    public function actionStaff()
    {
        $staff = Empl::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC])
            ->all();
        return $staff;
    }

    public function actionDismissedStaff()
    {
        $dismissed_staff = Empl::find()
            ->where(['status' => self::STATUS_DELETED])
            ->orderBy(['surname' => SORT_ASC])
            ->all();
        return $dismissed_staff;
    }

  	public function actionDismiss($id)
    {
        $model = $this->findModel($id);
	    Yii::$app->db->createCommand()->update('employee', ['status' => self::STATUS_DELETED], 'id='.$model->id)->execute();
	    return $this->redirect(['dismissed-staff']);
    }

    public function actionRestoreWork($id)
	{
	    $model = $this->findModel($id);
	    Yii::$app->db->createCommand()->update('employee', ['status' => self::STATUS_ACTIVE], 'id='.$model->id)->execute();
	    return $this->redirect(['staff']);
	}

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        $login = Yii::$app->getRequest()->getBodyParam('login');
        $role = Yii::$app->getRequest()->getBodyParam('role');
        $surname = Yii::$app->getRequest()->getBodyParam('surname');
        $name = Yii::$app->getRequest()->getBodyParam('name');
        $fathername = Yii::$app->getRequest()->getBodyParam('fathername');
        $passport_series = Yii::$app->getRequest()->getBodyParam('passport_series');
        $passport_number = Yii::$app->getRequest()->getBodyParam('passport_number');
        $birth_date = Yii::$app->getRequest()->getBodyParam('birth_date');
        $date_of_employment = Yii::$app->getRequest()->getBodyParam('date_of_employment');
        $passport_issued_by = Yii::$app->getRequest()->getBodyParam('passport_issued_by');
        $date_of_issue_of_passport = Yii::$app->getRequest()->getBodyParam('date_of_issue_of_passport');
        $email = Yii::$app->getRequest()->getBodyParam('email');
        $telephone = Yii::$app->getRequest()->getBodyParam('telephone');
        $pass = Yii::$app->getRequest()->getBodyParam('pass');


            if (($model->login !== $login)
                && (Empl::find()
                    ->where(['login' => $login])
                    ->count() == 0)) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['login' => $login], 'id='.$model->id)
                    ->execute();
            }
            if ($model->role !== $role) {
                $auth = Yii::$app->authManager;
                $admin = $auth->getRole('admin');
                $director = $auth->getRole('director');
                $manager = $auth->getRole('manager');
                if ($role == 'Администратор') {
                    $auth->revokeAll($model->id);
                    $auth->assign($admin, $model->id);
                } elseif ($role == 'Директор') {
                    $auth->revokeAll($model->id);
                    $auth->assign($director, $model->id);
                } elseif ($role == 'Менеджер') {
                    $auth->revokeAll($model->id);
                    $auth->assign($manager, $model->id);
                }
                Yii::$app->db->createCommand()
                    ->update('employee', ['role' => $role], 'id='.$model->id)
                    ->execute();
            }
            if ($model->surname !== $surname) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['surname' => $surname], 'id='.$model->id)
                    ->execute();
            }
            if ($model->name !== $name) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['name' => $name], 'id='.$model->id)
                    ->execute();
            }
            if ($model->fathername !== $fathername) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['fathername' => $fathername], 'id='.$model->id)
                    ->execute();
            }
            if ($model->passport_series !== $passport_series) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['passport_series' => $passport_series], 'id='.$model->id)
                    ->execute();
            }
            if ($model->passport_number !== $passport_number) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['passport_number' => $passport_number], 'id='.$model->id)
                    ->execute();
            }
            if ($model->birth_date !== $birth_date) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['birth_date' => $birth_date], 'id='.$model->id)
                    ->execute();
            }
            if ($model->date_of_employment !== $date_of_employment) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['date_of_employment' => $date_of_employment], 'id='.$model->id)
                    ->execute();
            }
            if ($model->passport_issued_by !== $passport_issued_by) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['passport_issued_by' => $passport_issued_by], 'id='.$model->id)
                    ->execute();
            }
            if ($model->date_of_issue_of_passport !== $date_of_issue_of_passport) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['date_of_issue_of_passport' => $date_of_issue_of_passport], 'id='.$model->id)->execute();
            }
            if (($model->email !== $email)
                && (Empl::find()
                    ->where(['email' => $email])
                    ->count() == 0)) {
                Yii::$app->db->createCommand()
                    ->update('employee', ['email' => $email], 'id='.$model->id)->execute();
            }
            if (($model->telephone !== $telephone)
                && (Empl::find()
                    ->where(['telephone' => $telephone])
                    ->count() == 0)){
                Yii::$app->db->createCommand()
                    ->update('employee', ['telephone' => $telephone], 'id='.$model->id)->execute();
            }
            if ($model->pass !== $pass) {
                $password = Yii::$app->security->generatePasswordHash($pass);
                Yii::$app->db->createCommand()
                    ->update('employee', ['pass' => $password], 'id='.$model->id)->execute();
            }

        return $this->redirect(['staff']);

    }

  	protected function findModel($id)
    {
        if (!empty(($model = Empl::findOne($id)))) {
            return $model;
        } return false;
    }
}
