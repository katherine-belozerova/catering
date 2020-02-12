<?php


namespace frontend\controllers;

use common\models\Client;
use common\models\Organization;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ClientController extends ApiController
{
    public $modelClass = Client::class;

    protected function verbs()
    {
        return [
            'create' => ['POST', 'OPTIONS'],
            'sort-by' => ['GET', 'OPTIONS'],
            'search' => ['GET', 'OPTIONS'],
            'list' => ['GET', 'OPTIONS'],
            'delete' => ['POST', 'OPTIONS'],
            'update' => ['POST', 'OPTIONS'],
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
                    'actions' => [
                        'sort-by',
                        'create',
                        'search',
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
                    'actions' => [
                        'sort-by',
                        'create',
                        'search',
                        'list',
                        'delete',
                        'update',
                    ],
                    'allow' => true,
                    'roles' => ['manager'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionList()
    {
        $field = 'id';
        $type = SORT_DESC;
        $model = new Client();
        return $model->list_of_clients($field, $type);
    }

    public function actionSortBy($field)
    {
        $type = SORT_ASC;
        $model = new Client();
        return $model->list_of_clients($field, $type);

    }

    public function actionSearch($searching)
    {
        $model = new Client();
        return $model->search($searching);
    }
}