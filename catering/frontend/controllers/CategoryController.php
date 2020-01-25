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
        $n = $n+1;
        $k = 1;
        $conformity = [];
        for($i=1;$i<$n;$i++) {
            $conformity[$k] = [
                "category_id" => $i,
                "" => Categories::find()->select('name')
                    ->where(['category_id' => $i])
                    ->one(),
                "number" => Dishes::find()
                ->where(['category_id' => $i])
                ->count()];
            $k++;
        }
        return $conformity;
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
