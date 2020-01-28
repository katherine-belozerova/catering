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
            'edit' => ['POST', 'OPTIONS'],
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
                    'actions' => ['sort-by', 'create', 'edit', 'list', 'delete', 'update', 'view', 'index'],
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['sort-by', 'create', 'edit', 'list', 'delete'],
                    'allow' => true,
                    'roles' => ['manager'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionSortBy($sort)
    {
        $sorting = Organization::find()
            ->orderBy([$sort => SORT_ASC])
            ->all();
        return $sorting;
    }

    public function actionList()
    {
        $org = Organization::find()
            ->orderBy(['organization_id' => SORT_DESC])
            ->all();
        return $org;
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        $name = Yii::$app->getRequest()->getBodyParam('name');
        $address = Yii::$app->getRequest()->getBodyParam('address');
        $inn = Yii::$app->getRequest()->getBodyParam('inn');

        if (($model->inn !== $inn)
            && (Organization::find()
                    ->where(['inn' => $inn])
                    ->count() == 0)) {
            Yii::$app->db->createCommand()
                ->update('organization', ['inn' => $inn], 'id=' . $model->id)
                ->execute();
        } elseif (($model->inn !== $inn)
            && (Organization::find()
                    ->where(['inn' => $inn])
                    ->count() > 0)) {
            return "Данный ИНН уже используется";
        }
        if ($model->name !== $name) {
            Yii::$app->db->createCommand()
                ->update('organization', ['name' => $name], 'id=' . $model->id)
                ->execute();
        }
        if ($model->address !== $address) {
            Yii::$app->db->createCommand()
                ->update('organization', ['address' => $address], 'id=' . $model->id)
                ->execute();
        }
    }
}