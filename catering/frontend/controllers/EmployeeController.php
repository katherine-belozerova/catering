<?php

namespace frontend\controllers;

use Yii;
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

    public $modelClass = Employee::class;

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
            'delete' => ['POST', 'OPTIONS'],
            'search-in-dismissed-staff' => ['GET', 'OPTIONS'],
            'update' => ['POST', 'OPTIONS']
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'denyCallback' => function ($rule, $action) {
                throw new \Exception('У Вас нет прав для доступа к данной странице');
            },
            'rules' => [
                [
                    'actions' => [
                        'view',
                        'create',
                        'update',
                        'dismiss',
                        'restore-work',
                        'staff',
                        'dismissed-staff',
                        'edit',
                        'delete',
                        'search',
                        'search-in-dismissed-staff',
                        'sort-in-dismissed-staff'
                    ],
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                    'actions' => [
                        'staff',
                        'dismissed-staff',
                        'sort-by',
                        'sort-in-dismissed-staff',
                        'search',
                        'search-in-dismissed-staff',
                        'dismiss',
                        'restore-work',
                        'update',
                        'create',
                        'view',
                    ],
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionSortBy($field)
    {
        $type = SORT_ASC;
        $status = self::STATUS_ACTIVE;
        $model = new Employee();
        return $model->sorting($field, $type, $status);
    }

    public function actionSortInDismissedStaff($field)
    {
        $type = SORT_ASC;
        $status = self::STATUS_DELETED;
        $model = new Employee();
        return $model->sorting($field, $type, $status);
    }

    public function actionSearch($searching)
    {
        $status = self::STATUS_ACTIVE;
        $model = new Employee();
        return $model->search($searching, $status);
    }

    public function actionSearchInDismissedStaff($searching)
    {
        $status = self::STATUS_DELETED;
        $model = new Employee();
        return $model->search($searching, $status);
    }

    public function actionStaff()
    {
        $field = 'id';
        $type = SORT_DESC;
        $status = self::STATUS_ACTIVE;
        $model = new Employee();
        return $model->sorting($field, $type, $status);
    }

    public function actionDismissedStaff()
    {
        $field = 'surname';
        $type = SORT_ASC;
        $status = self::STATUS_DELETED;
        $model = new Employee();
        return $model->sorting($field, $type, $status);
    }

    public function actionDismiss($id)
    {
        $status = self::STATUS_DELETED;
        $model = new Employee();
        $model->change_status($id, $status);
        return $this->redirect('dismissed-staff');
    }

    public function actionRestoreWork($id)
    {
        $status = self::STATUS_ACTIVE;
        $model = new Employee();
        $model->change_status($id, $status);
        return $this->redirect('staff');
    }
}
