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
					'actions' => ['view', 'index', 'create', 'update', 'delete-category', 'dishes', 'list'],
					'allow' => true,
					'roles' => ['manager'],
				],
			],
		];
		 	return $behaviors;
  	}

  	public function actionList()
    {
        $n = Categories::find()
            ->count();
        $k = 1;
        $names = Categories::find()->select('name')->all();
        $category_ids = Categories::find()->select('category_id')->all();
        for($i=0;$i<$n;$i++) {
            $categories[$k] = [
                "category_id" => $category_ids[$i],
                "name" => $names[$i],
                "number" => Dishes::find()
                    ->where(['category_id' => $category_ids[$i]])
                    ->count()
            ];
            $k++;
        }
        return $categories;
    }

  	public function actionDeleteCategory($id)
  	{
		$model = $this->findModel($id);
		Dishes::deleteAll('category_id = :id', [':id' => $id]);
		Categories::deleteAll('category_id = :id', [':id' => $id]);
	    return $this->redirect(['list']);
  	}

  	public function actionDishes($id)
  	{
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
