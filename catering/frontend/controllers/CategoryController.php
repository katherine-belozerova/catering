<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Category;
use frontend\models\Dish;
use common\models\Dishes;
use common\models\Categories;
use frontend\models\Empl;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;

class CategoryController extends ApiController
{
	public $modelClass = Category::class;

    protected function verbs()
    {
        return [
            'index' => ['GET', 'OPTIONS'],
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
					'actions' => ['view', 'index', 'create', 'update', 'delete-category', 'dishes'],
					'allow' => true,
					'roles' => ['manager'],
				],

			],
		];
		 	return $behaviors;
  	}

  	public function actionDeleteCategory($id)
  	{
		$model = $this->findModel($id);
		Dishes::deleteAll('category_id = :id', [':id' => $id]);
		Categories::deleteAll('category_id = :id', [':id' => $id]);
	    return $this->redirect(['index']);
  	}

  	public function actionDishes($id)
  	{
  		$model = $this->findModel($id);
  		$query = Dishes::find()
  			->where(['category_id' => $id])
  			->orderBy(['name' => SORT_ASC])
  			->all();
  		return $query;
        

  	}

  	protected function findModel($id)
    {
        if (!empty(($model = Empl::findOne($id)))) {
            return $model;
        } return false;
    }

}
