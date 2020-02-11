<?php


namespace frontend\controllers;

use common\models\Organization;
use yii\filters\AccessControl;

class OrganizationController extends ApiController
{
    public $modelClass = Organization::class;

    protected function verbs()
    {
        return [
            'create' => ['POST', 'OPTIONS'],
            'list' => ['GET', 'OPTIONS'],
            'sort-by' => ['GET', 'OPTIONS'],
            'update' => ['POST', 'OPTIONS'],
            'delete' => ['POST', 'OPTIONS'],
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
                    'actions' =>
                    [
                        'sort-by',
                        'create',
                        'list',
                        'delete',
                        'update',
                        'view',
                        'index'
                    ],
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                    'actions' =>
                    [
                        'sort-by',
                        'update',
                        'list',
                        'delete'
                    ],
                    'allow' => true,
                    'roles' => ['manager'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionSortBy($field)
    {
        $type = SORT_ASC;
        $model = new Organization();
        return $model->sorting($field, $type);
    }

    public function actionList()
    {
        $type = SORT_DESC;
        $field = 'organization_id';
        $model = new Organization();
        return $model->sorting($field, $type);
    }

    public function actionSearch($searching)
    {
        $model = new Organization();
        return $model->search($searching);
    }
}