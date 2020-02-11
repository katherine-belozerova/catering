<?php

namespace frontend\controllers;

use Yii;
use common\models\Dishes;
use common\models\Categories;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;

class CategoryController extends ApiController
{
	public $modelClass = Categories::class;

    protected function verbs()
    {
        return [
            'list' => ['GET', 'OPTIONS'],
            'create' => ['POST', 'OPTIONS'],
            'view' => ['GET', 'OPTIONS'],
            'update' => ['POST', 'OPTIONS'],
            'dishes' => ['GET', 'OPTIONS'],
            'delete-category' => ['POST', 'OPTIONS'],
        ];
    }

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
					'actions' => ['view', 'index', 'create', 'update', 'delete-category', 'dishes', 'list', 'normal-list'],
					'allow' => true,
					'roles' => ['manager'],
				],
			],
		];
		 	return $behaviors;
  	}

    public function actionList()
    {
        $model = new Categories();
        return $model->list_of_categories();
    }

  	public function actionDeleteCategory($id)
  	{
		$model = new Categories();
		$model->delete_all($id);
	    return $this->redirect(['list']);
  	}

  	public function actionDishes($id)
  	{
        return Dishes::find()
            ->where(['category_id' => $id])
            ->orderBy(['name' => SORT_ASC])
            ->all();
  	}
}
